#!/usr/bin/perl --
my $setting_file = './Setting.pm';
require $setting_file;

use strict;
use warnings;
use CGI;

my $cgi = CGI->new;
my $minutes = $cgi->param("minutes");
my $seconds = $cgi->param("seconds");
my $email = $cgi->param("email");
my $id = $cgi->param("id");

our $SAVE_TIME;

my $file_to_create = "$SAVE_TIME$email-$id.csv";

# Create a new file and add the current timestamp
open my $fh, '>', $file_to_create or die "Cannot create file: $!";

my $formatted_time = "$minutes,$seconds";

# Save hours:minutes:seconds format to file
print $fh "$formatted_time\n";

close $fh;

print "Content-Type: text/html\n\n";
