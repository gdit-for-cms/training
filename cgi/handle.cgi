#!/usr/bin/perl --
use CGI;
use JSON;
use Net::SMTP;
# use Email::Sender::Simple qw(sendmail);
# use Email::Simple;
# use Email::Simple::Creator;

my $cgi = CGI->new;

# Lấy dữ liệu gửi từ js qua.

# Thông tin người dùng
my $email = $cgi->param("email");
my $name = $cgi->param("name");

# File đáp án của bài test mà người dùng đang làm
my $file_csv = $cgi->param("file_csv");

# Kết quả của bài làm của người dùng
my $exam_results_json = $cgi->param("exam_results");

my $exam_results = decode_json($exam_results_json);

########################################################
# Đọc dữ liệu từ file đáp án
my %correct_answers;
my $file_path = "csv/" . $file_csv;

open(my $file_handle, "<", $file_path) or die "Cannot open $file_path: $!";

while (my $line = <$file_handle>) {
    chomp $line;
    my ($question_number, $correct_answer) = split(',', $line);
    $correct_answers{$question_number} = $correct_answer;
}
close($file_handle);

# Chấm điểm
my $score = 0;
foreach my $question (keys %$exam_results) {
    my $user_answer = $exam_results->{$question};
    if ($correct_answers{$question} eq $user_answer) {
        $score++;
    }
}

# In nội dung
# print "Received data: Email: $email, Name: $name<br>";
# print "Score: $score out of " . scalar(keys %$exam_results) . " questions<br>";

# foreach my $question (keys %$exam_results) {
#     my $answer = $exam_results->{$question};
#     print "Question: $question, Your Answer: $answer, Correct Answer: $correct_answers{$question}<br>";
# }

# Gửi mail kết quả cho người dùng
my $to_email = $email;
my $from_email = 'pvlam0602@gmail.com';
my $subject = 'Test Email';
my $message = $score . '/10.';

# my $email = Email::Simple->create(
#     header => [
#         To      => $to_email,
#         From    => $from_email,
#         Subject => $subject,
#     ],
#     body => $message,
# );

# sendmail($email);
 
open(MAIL, "|/usr/sbin/sendmail -t");

# Email Header
print MAIL "To: $to_email\n";
print MAIL "From: $from_email\n";
print MAIL "Subject: $subject\n\n";
# Email Body

print MAIL $message;

close(MAIL);
print "Content-type: text/html\n\n";
print "Email Sent Successfully\n";