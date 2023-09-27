#!/usr/bin/perl --
my $setting_file = './Setting.pm';
require $setting_file;

use strict;
use warnings;
use CGI;
use Time::Piece;
use Text::CSV;

my $cgi = CGI->new; 
my $id = $cgi->param("id");
my $code = $cgi->param("code");

if(!$code || !$id){
    print "Content-Type: text/html\n\n";
    print "0\n";
    exit(0);
}

my $time_path = our $TIME;

my $file_to_create = "$time_path$code-$id.csv";

if (-e $file_to_create) {
    my @timestamps;
    open my $file_handle, '<', $file_to_create or die "Cannot open file: $!";
    
    # Đọc các mốc thời gian từ tệp
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
        while (<$file_handle>) {
            if (/(.+)$/) {
                push @timestamps, Time::Piece->strptime($1, "%H:%M:%S");
            }
        }
        
        my ($hour1, $min1, $sec1) = split(":", $timestamps[0]);
        my ($hour2, $min2, $sec2) = split(":", $timestamps[1]);

        if($min2 - $min1 < 10){
            print "Content-Type: text/html\n\n";
            print "1\n";
        } elsif ($min2 - $min1 == 10 && $sec2 - $sec1 <= 30) {
            print "Content-Type: text/html\n\n";
            print "1\n";
        } else {
            print "Content-Type: text/html\n\n";
            print "0\n";
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

