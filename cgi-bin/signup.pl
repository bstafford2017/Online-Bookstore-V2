#!/usr/bin/perl
use strict;
use warnings;
use CGI; 
my $query = new CGI;
my $name = $query->param('name');
my $username = $query->param('username');
my $password = $query->param('password');
my $admin = $query->param('admin');


print("Content-type: text/html\n\n");
my $compile = "/usr/bin/javac Signup.java";
system($compile);
my $cmd = "";
if(!defined $name && !defined $username && !defined $password && !defined $admin){
    $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Signup ";
} else {
    $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Signup " . $name . " " . $username . " " . $password . " " . $admin;
}
system($cmd);
