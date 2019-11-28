#!/usr/bin/perl
use strict;
use warnings;
use CGI; 
my $query = new CGI;

my $compile = "/usr/bin/javac Delete.java";
system($compile);

my $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Delete";

print("Content-type: text/html\n\n");

my $isbn = $query->param('isbn');
$cmd = $cmd . " " . $isbn;
print($cmd);
system($cmd);