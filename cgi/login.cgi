#!/usr/bin/perl --

use CGI;
use strict;
use warnings;
use DBI;

my $cgi = CGI->new;
my $email = $cgi->param("email");   

my $database = 'intern';
my $hostname = 'localhost';
my $port     = '3306';
my $username = 'root';
my $password = 'cms-8341';

my $dbh = DBI->connect("DBI:mysql:database=$database;host=$hostname;port=$port", $username, $password)
  or die "Không thể kết nối đến cơ sở dữ liệu: $DBI::errstr";

my $query = "SELECT * FROM emails WHERE email = ?";

my $sth = $dbh->prepare($query);
$sth->execute($email);

my $result = $sth->fetchrow_array();

if ($result) {
    my $query = "SELECT * FROM emails WHERE email = ? AND code IS NOT NULL";

    my $sth = $dbh->prepare($query);
    $sth->execute($email);

    my $res = $sth->fetchrow_hashref();
    if($res){
        my $query = "UPDATE emails SET code = NULL WHERE email = ?";
        my $sth = $dbh->prepare($query);
        $sth->execute($email);

        print "Content-Type: text/html\n\n";
        print "true";
    } else {
        print "Content-Type: text/html\n\n";
        print "code_false";
    }
} else {
    print "Content-Type: text/html\n\n";
    print "mail_false";
}

# Đóng kết nối đến cơ sở dữ liệu
$dbh->disconnect();