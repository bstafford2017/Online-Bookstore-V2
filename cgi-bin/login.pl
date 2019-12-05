#!/usr/bin/perl
use strict;
use warnings;
use CGI; 
my $query = new CGI;
my $username = $query->param('username');
my $password = $query->param('password');

my $compile = "/usr/bin/javac Login.java";
system($compile);

my $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Login ";
$cmd .= $username . " " . $password;

print("Content-type: text/html\n\n");
print($cmd);
system($cmd);