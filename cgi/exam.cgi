#!/usr/bin/perl --
use strict;
use warnings;
use Text::CSV;
use CGI;
use CGI::Session;
use CGI::Cookie;
use List::Util qw/shuffle/;
use HTML::TreeBuilder;
use Scalar::Util qw(looks_like_number);
use Time::Piece;

my $setting_file = './Setting.pm';
require $setting_file;

my $cgi = CGI->new;

# Get data value from cookie (if any)
my $id_cookie = $cgi->cookie('id');
my $email_cookie = $cgi->cookie('email');

# Get or create a new session
my $session = CGI::Session->new(undef, $cgi, {Directory => '/tmp'});

# Get data from session (if any)
my $id_session = $session->param('id');
my $email_session = $session->param('email');

# Get data from form (if any)
my $id_form = $cgi->param('id');
my $email_form = $cgi->param('email');

my $id = $id_form || $id_session || $id_cookie; # Nếu không có id thì đá ra lại login, rồi khi người dùng nhập thông tin thì thông báo truy cập lại link đã gửi.
my $email = $email_form || $email_session || $email_cookie;

# Save data to sessions and cookies
# Save id
$session->param('id', $id);
my $cookie_id = CGI::Cookie->new(
    -name => 'id',
    -value => $id,
    -expires => '+1h'
);

# Save email
$session->param('email', $email);
my $cookie_email = CGI::Cookie->new(
    -name => 'email',
    -value => $email,
    -expires => '+1h'
);

# Send both cookies in the header
print $cgi->header(-cookie => [$cookie_id, $cookie_email]);

$session->flush();

# if(!looks_like_number($id) || !$email || !$code){
#     $id_last = $session->param('id');
#     $email_last = $session->param('email');
#     $code_last = $session->param('code');
# } else {
#     $id_last = $id;
#     $email_last = $email;
#     $code_last = $code;
# }

#########################################
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
    }
} else {
    print "Content-Type: text/html\n\n";
    print 2;
}
##########################################
our $HTML;
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
print $html_content;

# Clean up the original HTML::TreeBuilder object
$tree->delete;
