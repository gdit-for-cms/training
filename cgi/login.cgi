#!/usr/bin/perl --

use strict;
use warnings;
use Text::CSV;
use CGI;
use Scalar::Util qw(looks_like_number);

my $cgi = CGI->new;

# User information.
my $email = $cgi->param("email");
my $id = $cgi->param("id");
# Biến chứa nội dung của tệp CSV
if(!$email || !looks_like_number($id)){
    print "Content-Type: text/html\n\n";
    print -1;
    exit(0);
}
my $csv_file = "email/email$id.csv";

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
    if ($csv_data{$email}[0] == 1 && $csv_data{$email}[1] == 2) {
        $csv_data{$email}[0] = 0;
        $csv_data{$email}[1] = 2;
        
        # Record data to a CSV file
        open my $output_fh, '>', $csv_file or die "Không thể mở tệp $csv_file: $!";
        foreach my $key (keys %csv_data) {
            $csv->print($output_fh, [$key, @{$csv_data{$key}}]);
            print $output_fh "\n";
        }
        close $output_fh;
        
        print "Content-Type: text/html\n\n";
        print 1;
    } else {
        print "Content-Type: text/html\n\n";
        print 0;
    }
} else {
    print "Content-Type: text/html\n\n";
    print 2;
}
