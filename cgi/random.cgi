#!/usr/bin/perl --
use strict;
use warnings;
use CGI;

my $setting_file = './Setting.pm';
require $setting_file;

my $cgi = CGI->new;
my $id = $cgi->param("id");
my $code = $cgi->param("code");

our $RANDOM;

if(!$id || !$code){
    print "Content-Type: text/html\n\n";
    print -1;
    exit(0);
}

my $random_file = "$RANDOM$id.csv";

open(my $fh, '<', $random_file) or die "Không thể mở tệp '$random_file' $!";

# Đọc nội dung từ tệp CSV vào một mảng
my @data;
while (my $line = <$fh>) {
    chomp $line;
    push @data, $line;
}

# Đóng tệp CSV
close($fh);

# Kiểm tra xem $a có tồn tại trong mảng hay không
if (grep { $_ eq $code } @data) {
    print "Content-Type: text/html\n\n";
    print 1;
} else {
    print "Content-Type: text/html\n\n";
    print 0;
}

