#!/usr/bin/perl --
my $setting_file = './Setting.pm';
require $setting_file;

use strict;
use warnings;
use CGI;

my $cgi = CGI->new; 
my $id = $cgi->param("exam");

my $HTML = our $HTML;

# Path to the HTML file
my $html_file = "$HTML/$id.html";

# Read the contents of the HTML file
open my $fh, '<', $html_file or die "Cannot open file HTML: $!";
my @html_lines = <$fh>;
close $fh;

# Combine content into a string
my $html_content = join('', @html_lines);

# Find and store sections that contain questions and their corresponding answers
my @question_sections;
while ($html_content =~ /(<div class="my-3 p-3 bg-body rounded shadow-sm">.*?<\/div>)/sg) {
    push @question_sections, $1;
}

# Shuffle the positions of the question sections along with their answers
@question_sections = shuffle(@question_sections);

# Regenerate obfuscated HTML content
my $shuffled_html = $html_content;
my $i = 0;
$shuffled_html =~ s/<div class="my-3 p-3 bg-body rounded shadow-sm">(.*?)<\/div>/<div class="my-3 p-3 bg-body rounded shadow-sm">$question_sections[$i++]<\/div>/sg;

# Print scrambled HTML content to the screen
print "Content-Type: text/html\n\n";
print $shuffled_html;

# The function shuffles the array
sub shuffle {
    my @array = @_;
    my $n = @array;
    for (my $i = $n - 1; $i > 0; $i--) {
        my $j = int(rand($i + 1));
        @array[$i, $j] = @array[$j, $i];
    }
    return @array;
}
