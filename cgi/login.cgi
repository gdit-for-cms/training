#!/usr/bin/perl --
my $setting_file = './Setting.pm';
require $setting_file;

use strict;
use warnings;
use Text::CSV;
use CGI;
use Scalar::Util qw(looks_like_number);
use Time::Piece;

my $cgi = CGI->new;

# User information.
my $email = $cgi->param("email");
my $id = $cgi->param("id");
my $code = $cgi->param("code");
my $random = $cgi->param("random");

# Biến chứa nội dung của tệp CSV
if(!$email || !looks_like_number($id) || !$code || !$random){
    print "Content-Type: text/html\n\n";
    print -1;
    exit(0);
}
my $email_path = our $EMAIL;

my $csv_file = "$email_path$id.csv";

# Read CSV file and create object variable
my %csv_data;

my $csv = Text::CSV->new({ binary => 1 }) or die "Unable to create object CSV: " . Text::CSV->error_diag();
open my $fh, '<', $csv_file or die "Cannot open file $csv_file: $!";

while (my $row = $csv->getline($fh)) {
    my ($csv_email, $value_random, $value1, $value2, $value_mark) = @$row;
    $csv_data{$csv_email} = [$value_random, $value1, $value2, $value_mark];
}

$csv->eof or $csv->error_diag();
close $fh;

# Check if $email exists in the object and make changes if necessary
if (exists $csv_data{$email}) {
    my $text = $csv_data{$email}[0];
    if ($csv_data{$email}[0] eq $random) {
        if ($csv_data{$email}[1] == 1 && $csv_data{$email}[2] == 2) {
            print "Content-Type: text/html\n\n";
            print 1;
        } elsif($csv_data{$email}[1] == 0 && $csv_data{$email}[2] == 2) {
            our $TIME;
            our $SAVE_TIME;
            our $TIME_TEST;

            my $file_to_create = "$TIME$code-$id.csv";
            my $file_save_time = "$SAVE_TIME$code-$id.csv";

            if (-e $file_to_create) {
                # Create a new file and add the current timestamp
                open my $file_handle, '<', $file_to_create or die "Cannot open file: $!";
                my @times;
                while (<$file_handle>) {
                    if (/(.+)$/) {
                        push @times, Time::Piece->strptime($1, "%H:%M:%S");
                    }
                }
                close $file_handle;

                my ($hour1, $min1, $sec1) = split(":", $times[0]);
                my ($sec2, $min2, $hour2) = (localtime)[0, 1, 2];
                $hour1 = substr($hour1, length($hour1) - 2, 2);
                my $total_sec_1 = $hour1*3600 + $min1*60 + $sec1;
                my $total_sec_2 = $hour2*3600 + $min2*60 + $sec2;
                
                my $dif_sec = $total_sec_2 - $total_sec_1;

                if ($dif_sec > $TIME_TEST || $dif_sec == $TIME_TEST) {
                    print "Content-Type: text/html\n\n";
                    print "4\n";
                } else {
                    my $time_left = 600 - $dif_sec;
                    my $min = int($time_left / 60);
                    my $sec = $time_left % 60;
                    if (-e $file_save_time){
                        # Create a new file and add the current timestamp
                        open my $fh_save_time, '>', $file_save_time or die "Cannot create file: $!";

                        my $formatted_time = "$min,$sec";

                        # Save hours:minutes:seconds format to file
                        print $fh_save_time "$formatted_time\n";

                        close $fh_save_time;

                        print "Content-Type: text/html\n\n";
                        print 3;
                    } else {
                        print "Content-Type: text/html\n\n";
                        print -1;
                    }
                }
            } else {
                print "Content-Type: text/html\n\n";
                print -1;
            }
        } else {
            print "Content-Type: text/html\n\n";
            print 0;
        }
    } else {
        print "Content-Type: text/html\n\n";
        print 5;
    }
} else {
    print "Content-Type: text/html\n\n";
    print 2;
}
