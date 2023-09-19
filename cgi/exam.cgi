#!/usr/bin/perl --
use strict;
use warnings;

# Đường dẫn đến tệp HTML
my $html_file = "/htdocs/training2/training/server_public/1.html"; # Thay thế bằng đường dẫn đến tệp HTML của bạn

# Đọc nội dung của tệp HTML
open my $fh, '<', $html_file or die "Không thể mở tệp HTML: $!";
my @html_lines = <$fh>;
close $fh;

# Gộp nội dung thành một chuỗi
my $html_content = join('', @html_lines);

# Tìm và lưu trữ các phần chứa câu hỏi
my @question_sections;
while ($html_content =~ /<div class="my-3 p-3 bg-body rounded shadow-sm">(.*?)<\/div>/sg) {
    push @question_sections, $1;
}

# Xáo trộn vị trí của các câu hỏi
@question_sections = shuffle(@question_sections);

# Tạo lại nội dung HTML đã được xáo trộn
my $shuffled_html = $html_content;
my $i = 0;
$shuffled_html =~ s/<div class="my-3 p-3 bg-body rounded shadow-sm">(.*?)<\/div>/<div class="my-3 p-3 bg-body rounded shadow-sm">$question_sections[$i++]<\/div>/sg;

# In nội dung HTML xáo trộn ra màn hình
print "Content-Type: text/html\n\n";
print $shuffled_html;

# Hàm xáo trộn mảng
sub shuffle {
    my @array = @_;
    my $n = @array;
    for (my $i = $n - 1; $i > 0; $i--) {
        my $j = int(rand($i + 1));
        @array[$i, $j] = @array[$j, $i];
    }
    return @array;
}
