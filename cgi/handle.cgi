#!/usr/bin/perl --
use CGI;
use JSON;

use Net::SMTP;

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

while (my $line = <$file_handle>) {
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
my $to_email = 'pvlam0602@gmail.com';
my $subject = 'Chủ đề của email';
my $message = 'Nội dung của email';

my $sendmail_cmd = '/usr/sbin/sendmail';

# Tạo một pipe để ghi dữ liệu vào lệnh sendmail
open my $mail_pipe, '|-', "$sendmail_cmd -t" or die "Không thể mở pipe đến sendmail: $!";

print $mail_pipe "To: $to_email\n";
print $mail_pipe "Subject: $subject\n";
print $mail_pipe "\n";
print $mail_pipe $message;
print "Content-type: text/html\n\n";

close $mail_pipe or die "Lỗi khi gửi email: $!";
