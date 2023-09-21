#!/usr/bin/perl --
use strict;
use warnings;
use CGI;
use Time::Piece;
use Text::CSV;

my $cgi = CGI->new; 
my $id = $cgi->param("id");
my $random_code = $cgi->param("code");

sub generate_random_string {
    my $random_string = '';
    my @characters = ('A'..'Z', 'a'..'z', 0..9);
    
    for (1..4) {
        my $random_index = int(rand(scalar(@characters)));
        $random_string .= $characters[$random_index];
    }

    return $random_string;
}

if(!$random_code){
    
    $random_code = generate_random_string();
}

my $file_to_create = "time/$random_code-$id.csv";

if (-e $file_to_create) {
    my @timestamps;
    open my $file_handle, '<', $file_to_create or die "Can not open file: $!";
    
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
        open $file_handle, '>>', $file_to_create or die "Can not open file: $!";
        my ($second, $minute, $hour) = (localtime)[0, 1, 2]; # Lấy giây, phút, giờ

        # Tạo định dạng giờ:phút:giây
        my $formatted_time = sprintf("%02d:%02d:%02d", $hour, $minute, $second);

        # Lưu định dạng giờ:phút:giây vào tệp tin
        print $file_handle "$formatted_time\n";
        close $file_handle;

        # Take 2 time points to check
        open $file_handle, '<', $file_to_create or die "Không thể mở tệp: $!";
    
        # Đọc các mốc thời gian từ tệp
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
    # Create a new file and add the current timestamp
    open my $fh, '>', $file_to_create or die "Không thể tạo mới tệp: $!";

    my ($second, $minute, $hour) = (localtime)[0, 1, 2]; # Lấy giây, phút, giờ

    # Tạo định dạng giờ:phút:giây
    my $formatted_time = sprintf("%02d:%02d:%02d", $hour, $minute, $second);

    # Lưu định dạng giờ:phút:giây vào tệp tin
    print $fh "$formatted_time\n";
    
    close $fh;

    print "Content-Type: text/html\n\n";
    print $random_code;
}

