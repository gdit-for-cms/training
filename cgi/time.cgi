#!/usr/bin/perl --
use strict;
use warnings;
use CGI;
use Time::Piece;

my $cgi = CGI->new; 
my $id = $cgi->param("id");

my $file_to_create = "time/$id.csv";

if (-e $file_to_create) {
    my @timestamps;
    open my $file_handle, '<', $file_to_create or die "Không thể mở tệp: $!";
    
    # Đọc các mốc thời gian từ tệp
    while (<$file_handle>) {
        if (/(.+)$/) {
            push @timestamps, Time::Piece->strptime($1, "%a %b %d %H:%M:%S %Y");
        }
    }
    
    close $file_handle;

    if (@timestamps == 1) {
        # TH1: File đã có một mốc thời gian
        # Thêm mốc thời gian hiện tại vào tệp
        open $file_handle, '>>', $file_to_create or die "Không thể mở tệp: $!";
        my $current_time = localtime;
        print $file_handle "$current_time\n";
        close $file_handle;

        # Lấy 2 mốc thời gian ra kiểm tra
        my $time1 = $timestamps[0];
        my $time2 = $timestamps[1];

        my $time_difference = $time2 - $time1;

        if ($time_difference->minutes > 10 || ($time_difference->minutes == 10 && $time_difference->seconds > 30)) {
            print "Content-Type: text/html\n\n";
            print "0\n";
        } else {
            print "Content-Type: text/html\n\n";
            print "1\n";
        }
    } elsif (@timestamps == 2) {
        # TH2: File đã có đủ 2 mốc thời gian
        print "Content-Type: text/html\n\n";
        print "2\n";
    } else {
        # TH3: File chưa có mốc thời gian nào
        print "Content-Type: text/html\n\n";
        print "1\n";
    }
} else {
    # Tạo mới tệp và thêm mốc thời gian hiện tại vào
    open my $fh, '>', $file_to_create or die "Không thể tạo mới tệp: $!";
    my $current_time = localtime;
    print $fh "$current_time\n";
    close $fh;
}

