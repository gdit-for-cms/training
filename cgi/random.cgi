#!/usr/bin/perl --
use strict;
use warnings;
use CGI;
use Scalar::Util qw(looks_like_number);

my $setting_file = './Setting.pm';
require $setting_file;

my $cgi = CGI->new;
my $id = $cgi->param("id");
my $code = $cgi->param("code");

our $RANDOM;

if(!looks_like_number($id) || !$code){
    print "Content-Type: text/html\n\n";
    print -1;
    exit(0);
}

my $random_file = "$RANDOM$id.csv";

open(my $fh, '<', $random_file) or die "Cannot open file '$random_file' $!";

# Read content from CSV file into an array
my @data;
while (my $line = <$fh>) {
    chomp $line;
    push @data, $line;
}

close($fh);

# Checks if $a exists in the array
if (grep { $_ eq $code } @data) {
    print "Content-Type: text/html\n\n";
    print 1;
} else {
    print "Content-Type: text/html\n\n";
    print 0;
}

