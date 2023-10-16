#!/usr/bin/perl --
my $setting_file = './Setting.pm';
require $setting_file;

use CGI;
use JSON;
use strict;
use warnings;
use Text::CSV;
use File::Path;
use Scalar::Util qw(looks_like_number);
my $cgi = CGI->new;

# Get data sent from js.

# User information.
my $email = $cgi->param("email");
my $name = $cgi->param("name");
my $code = $cgi->param("code");
my $random = $cgi->param("random");
my $check = $cgi->param("check");

# The answer file of the test that the user is doing.
my $id = $cgi->param("id");
# Results of user's work.
my $exam_results_json = $cgi->param("exam_results");

my $exam_results = decode_json($exam_results_json);

my $time_path = our $TIME;
my $file_to_create = "$time_path$code-$id.csv";

our $SAVE_TIME;
my $file_save_time = "$SAVE_TIME$code-$id.csv";

# Read data from the answer file. 
my %correct_answers;

my $folder_to_check = our $CSV;

if(!$email || !looks_like_number($id) || !$name || !$code){
    print "Content-Type: text/html\n\n";
    print 0;
    exit(0);
}

##########################################

#####################################
if (-e $file_to_create) {
    unlink $file_to_create or die "Cannot delete file: $!";
} else {
    print "Content-Type: text/html\n\n";
    print 0;
    exit(0);
}

if (-e $file_save_time) {
    unlink $file_save_time or die "Cannot delete file: $!";
} else {
    print "Content-Type: text/html\n\n";
    print 0;
    exit(0);
}
##########################################
our $RANDOM;

my $random_file = "$RANDOM$id.csv";

open my $fh_random, '<', $random_file or die "Cannot open file $random_file: $!";
my @data = <$fh_random>;
close $fh_random;

chomp(@data);

my $found = 0;
for my $i (0..$#data) {
    if ($data[$i] eq $random) {
        splice(@data, $i, 1);
        $found = 1;
        last;
    }
}

if ($found) {
    open my $output_file, '>', $random_file or die "Cannot open file $random_file: $!";
    print $output_file join("\n", @data);
    close $output_file;
} else {
    print "Content-Type: text/html\n\n";
    print 0;
    exit(0);
}
#####################################
if($check == 1) {

    unless (-d $folder_to_check) {
        eval {
            mkpath($folder_to_check);
        };
        if ($@) {
            die "Unable to create directory: $@";
        }
    }

    my $file_path = "$folder_to_check/$id.csv";

    # eval {
        if ($check == 1) {
            open my $file_handle, '<', $file_path or die "Can not open file $file_path: $!";
            my $csv_f = Text::CSV->new({ binary => 1 });

            while (my $row = $csv_f->getline($file_handle)) {
                my ($question_id, $answer) = @$row;
                push @{$correct_answers{$question_id}}, $answer;
            }

            close $file_handle;

            # Mark.
            my $total_mark = 0;
            my $total_question = 0;
            while (my ($key, $value) = each %correct_answers) {
                $total_question++;
            }

            foreach my $question_id (keys %$exam_results) {
                my $user_answers = $exam_results->{$question_id};
                my $correct_answer = $correct_answers{$question_id};
                my  $mark = 0;
                my $count_ua = 0;
                my $count_ca = 0;

                foreach my $ele (@$user_answers) {
                    $count_ua++;
                }
                foreach my $ele (@$correct_answer) {
                    $count_ca++;
                }
                
                if ($count_ua == $count_ca) {
                    $mark = 1;

                    foreach my $user_answer (@$user_answers) {
                        unless (grep { $_ eq $user_answer } @$correct_answer) {
                            $mark = 0;
                            last;
                        }
                    }

                } else {
                    $mark = 0;
                }
                $total_mark += $mark;
            }

            ###############################################
            # Check the email you are logging in and whether this email has been submitted
            my $email_path = our $EMAIL;
            my $csv_file = "$email_path$id.csv";

            # Read CSV file and create object variable
            my %csv_data;

            my $csv = Text::CSV->new({ binary => 1 }) or die "Unable to create object CSV: " . Text::CSV->error_diag();
            open my $fh, '<', $csv_file or die "Cannot open file $csv_file: $!";

            while (my $row = $csv->getline($fh)) {
                my ($csv_email, $vlaue_random, $value1, $value2, $value_mark) = @$row;
                $csv_data{$csv_email} = [$vlaue_random, $value1, $value2, $value_mark];
            }

            $csv->eof or $csv->error_diag();
            close $fh;

            # Check if $email exists in the object and make changes if necessary
            if (exists $csv_data{$email}) {
                if ($csv_data{$email}[1] == 0 && $csv_data{$email}[2] == 2) {
                    $csv_data{$email}[1] = 0;
                    $csv_data{$email}[2] = 0;
                    $csv_data{$email}[3] = $total_mark;
                    
                    # Record data to a CSV file
                    open my $output_fh, '>', $csv_file or die "Cannot open file $csv_file: $!";
                    foreach my $key (keys %csv_data) {
                        $csv->print($output_fh, [$key, @{$csv_data{$key}}]);
                        print $output_fh "\n";
                    }
                    close $output_fh;
                } else {
                    print "Content-Type: text/html\n\n";
                    print 0;
                    exit(0);
                }
            } else {
                print "Content-Type: text/html\n\n";
                print 0;
                exit(0);
            }
            ##############################################

            # Email the results to the user.
            sub send_mail {
                print CGI::header();
                my ($to) = @_;
                my $from = our $EMAIL_FROM;
                my $subject = our $EMAIL_SUBJECT;
                my $message = "Dear $name\n";
                $message .= our $EMAIL_CONTENT;
                $message .= "Results: $total_mark / $total_question";
                open(MAIL, "|/usr/local/bin/catchmail --smtp-ip 192.168.1.208 -f $from");
                
                # Email Header
                print MAIL "To: $to\n";
                print MAIL "From: $from\n";
                print MAIL "Subject: $subject\n\n";
                # Email Body
                print MAIL $message;

                close(MAIL);
                
                print "Content-Type: text/html\n\n";
                print 1;
            }

            # Send mail for user
            send_mail($email);

            # Send mail for admin
            send_mail('hoangcongtruong10102001@gmail.com');
        };
    # };

    if ($@) {
        print "Content-Type: text/html\n\n";
        print "false";
    }
}
print "Content-Type: text/html\n\n";

