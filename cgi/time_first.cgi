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

unless (-e $file_to_create) {
    
    # Create a new file and add the current timestamp
    open my $fh, '>', $file_to_create or die "Cannot create file: $!";

    my ($second, $minute, $hour) = (localtime)[0, 1, 2]; # Lấy giây, phút, giờ

    # Tạo định dạng giờ:phút:giây
    my $formatted_time = sprintf("%02d:%02d:%02d", $hour, $minute, $second);

    # Lưu định dạng giờ:phút:giây vào tệp tin
    print $fh "$formatted_time\n";
    
    close $fh;

    print "Content-Type: text/html\n\n";
}
print "Content-Type: text/html\n\n";
