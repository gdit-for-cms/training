#!/usr/bin/perl --
use CGI;
use JSON;
use strict;
use warnings;
my $cgi = CGI->new;

# Get data sent from js.

# User information.
my $email = $cgi->param("email");
my $name = $cgi->param("name");

# The answer file of the test that the user is doing.
my $file_csv = $cgi->param("file_csv");

# Results of user's work.
my $exam_results_json = $cgi->param("exam_results");

my $exam_results = decode_json($exam_results_json);


# Read data from the answer file.
my %correct_answers;
my $file_path = "csv/" . $file_csv;

open(my $file_handle, "<", $file_path) or die "Cannot open $file_path: $!";
my $total_question = 0;
while (my $line = <$file_handle>) {
    $total_question++;
    chomp $line;
    my ($question_number, $correct_answer) = split(',', $line);
    $correct_answers{$question_number} = $correct_answer;
}
close($file_handle);

# Mark.
my $score = 0;
foreach my $question (keys %$exam_results) {
    my $user_answer = $exam_results->{$question};
    if ($correct_answers{$question} eq $user_answer) {
        $score++;
    }
}

# Email the results to the user.

print CGI::header();
my $to = $email;
my $from = 'hoangcongtruong10102001@gmail.com';
my $subject = 'Test Email';
my $message = "Dear $name\n";
$message .= "Thank you for participating in our test.\n";
$message .= "Results: $score / $total_question";
open(MAIL, '|/usr/local/bin/catchmail --smtp-ip 192.168.1.208 -f truong.hc@globaldesignit.vn');
 
# Email Header
print MAIL "To: $to\n";
print MAIL "From: $from\n";
print MAIL "Subject: $subject\n\n";
# Email Body
print MAIL $message;

close(MAIL);
print "Email Sent Successfully\n";


# print "Content-type: text/html\n\n";
# print $score, " ", $total_question;
