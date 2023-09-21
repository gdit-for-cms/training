#!/usr/bin/perl --
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

# The answer file of the test that the user is doing.
my $file_csv = $cgi->param("id");
# Results of user's work.
my $exam_results_json = $cgi->param("exam_results");

my $exam_results = decode_json($exam_results_json);


# Read data from the answer file.
my %correct_answers;

my $folder_to_check = "csv";

if(!$email || !looks_like_number($file_csv)){
    print "Content-Type: text/html\n\n";
    print 0;
    exit(0);
}

##########################################
# Check the email you are logging in and whether this email has been submitted

my $csv_file = "email/email$file_csv.csv";

# Read CSV file and create object variable
my %csv_data;

my $csv = Text::CSV->new({ binary => 1 }) or die "Unable to create object CSV: " . Text::CSV->error_diag();
open my $fh, '<', $csv_file or die "Cannot open file $csv_file: $!";

while (my $row = $csv->getline($fh)) {
    my ($csv_email, $value1, $value2) = @$row;
    $csv_data{$csv_email} = [$value1, $value2];
}

$csv->eof or $csv->error_diag();
close $fh;

# Check if $email exists in the object and make changes if necessary
if (exists $csv_data{$email}) {
    if ($csv_data{$email}[0] == 0 && $csv_data{$email}[1] == 2) {
        $csv_data{$email}[0] = 0;
        $csv_data{$email}[1] = 0;
        
        # Record data to a CSV file
        open my $output_fh, '>', $csv_file or die "Không thể mở tệp $csv_file: $!";
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
#####################################

$file_csv = "$file_csv.csv";

unless (-d $folder_to_check) {
    eval {
        mkpath($folder_to_check);
    };
    if ($@) {
        die "Unable to create directory: $@";
    }
}

my $file_path = "$folder_to_check/$file_csv";

eval {
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
    foreach my $question_id (keys %$exam_results) {
        my $user_answers = $exam_results->{$question_id};
        my $correct_answer = $correct_answers{$question_id};

        $total_question++;

        if ($user_answers && $correct_answer) {
            my $mark = 1;

            foreach my $user_answer (@$user_answers) {
                unless (grep { $_ eq $user_answer } @$correct_answer) {
                    $mark = 0;
                    last;
                }
            }

            $total_mark += $mark;
        }
    }

    # Email the results to the user.
    sub send_mail {
        print CGI::header();
        my ($to) = @_;
        my $from = 'truong.hc@globaldesignit.vn';
        my $subject = 'EMAIL TEST RESULTS';
        my $message = "Dear $name\n";
        $message .= "Thank you for participating in our test.\n";
        $message .= "Results: $total_mark / $total_question";
        open(MAIL, '|/usr/local/bin/catchmail --smtp-ip 192.168.1.208 -f truong.hc@globaldesignit.vn');
        
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

    send_mail($email);
    send_mail('hoangcongtruong10102001@gmail.com');
};

if ($@) {
    print "Content-Type: text/html\n\n";
    print "false";
}
