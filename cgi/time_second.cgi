#!/usr/bin/perl --
my $setting_file = './Setting.pm';
require $setting_file;

use strict;
use warnings;
use CGI;
use Time::Piece;
use Text::CSV;
use Scalar::Util qw(looks_like_number);

my $cgi = CGI->new; 
my $id = $cgi->param("id");
my $code = $cgi->param("code");

if(!$code || !looks_like_number($id)){
    print "Content-Type: text/html\n\n";
    print "0\n";
    exit(0);
}

my $time_path = our $TIME;
our $TIME_TEST;

my $file_to_create = "$time_path$code-$id.csv";

if (-e $file_to_create) {
    my @timestamps;
    open my $file_handle, '<', $file_to_create or die "Cannot open file: $!";
    
    # Read timestamps from file
    while (<$file_handle>) {
        if (/(.+)$/) {
            push @timestamps, Time::Piece->strptime($1, "%H:%M:%S");
        }
    }
    
    close $file_handle;

    if (@timestamps == 1) {
        # TH1: The file has been there for a while
        # Add the current timestamp to the file
        open $file_handle, '>>', $file_to_create or die "Cannot open file: $!";
        my ($second, $minute, $hour) = (localtime)[0, 1, 2];

        # Create hour:minute:second format
        my $formatted_time = sprintf("%02d:%02d:%02d", $hour, $minute, $second);

        # Save hours:minutes:seconds format to file
        print $file_handle "$formatted_time\n";
        close $file_handle;

        # Take 2 time points to check
        open $file_handle, '<', $file_to_create or die "Cannot open file: $!";
    
        # Read timestamps from file
        my @times;
        while (<$file_handle>) {
            if (/(.+)$/) {
                push @times, Time::Piece->strptime($1, "%H:%M:%S");
            }
        }
        close $file_handle;

        my ($hour1, $min1, $sec1) = split(":", $times[0]);
        my ($hour2, $min2, $sec2) = split(":", $times[1]);

        my $dif_hour = $hour2 - $hour1;
        my $dif_min = $min2 - $min1;
        my $dif_sec = $sec2 - $sec1;

        if ($dif_hour > 0) {
            if ($dif_min < 0) {
                $dif_min = 60 + $dif_min;
            }
            if ($dif_sec < 0) {
                $dif_sec = 60 + $dif_sec;
            }
        } elsif ($dif_hour == 0) {
            if ($dif_sec < 0) {
                $dif_sec = 60 + $dif_sec;
            }
        }

        if ($dif_hour > 1 || $dif_hour < 0) {
            print "Content-Type: text/html\n\n";
            print "0\n";
        } elsif ($dif_hour > -1 && $dif_hour < 2) {
            if ($dif_min < $TIME_TEST) {
                print "Content-Type: text/html\n\n";
                print "1\n";
            } elsif ($dif_min == $TIME_TEST && $dif_sec < 31) {
                print "Content-Type: text/html\n\n";
                print "1\n";
            } else {
                print "Content-Type: text/html\n\n";
                print "0\n";
            }
        }
    } elsif (@timestamps == 2) {
        # TH2: The file already has 2 timestamps
        print "Content-Type: text/html\n\n";
        print "0\n";
    } else {
        # TH3: The file does not have any time stamp
        print "Content-Type: text/html\n\n";
        print "0\n";
    }
} else {
    print "Content-Type: text/html\n\n";
    print "0\n";
    exit(0);
}

