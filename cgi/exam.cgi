#!/usr/bin/perl --
use strict;
use warnings;
use Text::CSV;
use CGI;
use List::Util qw/shuffle/;
use HTML::TreeBuilder;

my $setting_file = './Setting.pm';
require $setting_file;

my $cgi = CGI->new;
my $id = $cgi->param("exam");
my $email = $cgi->param("email");
my $code = $cgi->param("code");

our $HTML;

if(!$id || !$email || !$code){
    print "Content-Type: text/html\n\n";
    print -1;
    exit(0);
}
##########################################
my $email_path = our $EMAIL;

my $csv_file = "$email_path$id.csv";

# Read CSV file and create object variable
my %csv_data;

my $csv = Text::CSV->new({ binary => 1 }) or die "Unable to create object CSV: " . Text::CSV->error_diag();
open my $fh_login, '<', $csv_file or die "Cannot open file $csv_file: $!";

while (my $row = $csv->getline($fh_login)) {
    my ($csv_email, $value1, $value2) = @$row;
    $csv_data{$csv_email} = [$value1, $value2];
}

$csv->eof or $csv->error_diag();
close $fh_login;

# Check if $email exists in the object and make changes if necessary
if (exists $csv_data{$email}) {
    if ($csv_data{$email}[0] == 1 && $csv_data{$email}[1] == 2) {
        $csv_data{$email}[0] = 0;
        $csv_data{$email}[1] = 2;
        
        # Record data to a CSV file
        open my $output_fh, '>', $csv_file or die "Cannot open file $csv_file: $!";
        foreach my $key (keys %csv_data) {
            $csv->print($output_fh, [$key, @{$csv_data{$key}}]);
            print $output_fh "\n";
        }
        close $output_fh;
    } else {
        print "Content-Type: text/html\n\n";
        print 0;
    }
} else {
    print "Content-Type: text/html\n\n";
    print 2;
}
##########################################
our $RANDOM;

my $random_file = "$RANDOM$id.csv";

open my $fh_random, '<', $random_file or die "Cannot open file $random_file: $!";
my @data = <$fh_random>;
close $fh_random;

chomp(@data);

my $found = 0;
for my $i (0..$#data) {
    if ($data[$i] eq $code) {
        splice(@data, $i, 1);
        $found = 1;
        last;
    }
}

if ($found) {
    open my $output_file, '>', $random_file or die "Cannot open file $random_file: $!";
    print $output_file join("\n", @data);
    close $output_file;
} else {
    print "Content-Type: text/html\n\n";
    print 0;
    exit(0);
}
##########################################
# Path to the HTML file
my $html_file = "$HTML/$id.html";

# Read the contents of the HTML file
open my $fh, '<', $html_file or die "Cannot open file HTML: $!";
my $html_content = do { local $/; <$fh> };
close $fh;

# Create an HTML::TreeBuilder object
my $tree = HTML::TreeBuilder->new;
$tree->parse($html_content);

# Find the form with id "form_exam"
my $form_exam = $tree->look_down(_tag => 'form', id => 'form_exam');

if ($form_exam) {
    # Find all div elements with class "my-3 p-3 bg-body rounded shadow-sm" within the "form_exam"
    my @divs_in_form = $form_exam->look_down(_tag => 'div', class => 'my-3 p-3 bg-body rounded shadow-sm');
    
    if (@divs_in_form > 1) {
        # Shuffle the divs within the form
        @divs_in_form = shuffle @divs_in_form;
        
        # Create a placeholder div to hold the shuffled divs
        my $placeholder_div = HTML::Element->new('div');
        
        # Append the shuffled divs to the placeholder div
        foreach my $div (@divs_in_form) {
            $placeholder_div->push_content($div);
        }
        
        # Remove existing divs in the form
        $_->detach() foreach $form_exam->look_down(_tag => 'div', class => 'my-3 p-3 bg-body rounded shadow-sm');
        
        # Append the placeholder div to the form
        $form_exam->push_content($placeholder_div);
    }
    
    # Rebuild the HTML content with the modified tree
    my $shuffled_html = $tree->as_HTML;
    
    # Create a new HTML::TreeBuilder object for the shuffled HTML
    my $shuffled_tree = HTML::TreeBuilder->new;
    $shuffled_tree->parse($shuffled_html);
    
    # Find the form with id "form_exam" in the shuffled HTML
    my $shuffled_form_exam = $shuffled_tree->look_down(_tag => 'form', id => 'form_exam');
    
    if ($form_exam) {
        # Create a new HTML::TreeBuilder object for the shuffled HTML
        my $shuffled_tree = HTML::TreeBuilder->new;
        $shuffled_tree->parse($shuffled_html);
        
        # Find the form with id "form_exam" in the shuffled HTML
        my $shuffled_form_exam = $shuffled_tree->look_down(_tag => 'form', id => 'form_exam');
        
        if ($shuffled_form_exam) {
            # Get the HTML content of the shuffled form
            my $shuffled_form_html = $shuffled_form_exam->as_HTML;
            
            # Replace the form in the original HTML content with the shuffled form
            $html_content =~ s/<form id="form_exam">(.*?)<\/form>/$shuffled_form_html/sg;
        }
        
        # Clean up the shuffled HTML::TreeBuilder object
        $shuffled_tree->delete;
    }
    
    # Clean up the shuffled HTML::TreeBuilder object
    $shuffled_tree->delete;
}
# Print the modified HTML content
print "Content-type: text/html\n\n";
print $html_content;

# Clean up the original HTML::TreeBuilder object
$tree->delete;
