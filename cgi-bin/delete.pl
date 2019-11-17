#!/usr/bin/perl
use strict;
use warnings;
use CGI; 
my $query = new CGI;

my $compile = "/usr/bin/javac Delete.java";
system($compile);

my $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Delete ";

print("Content-type: text/html\n\n");

my @names = $query->param;
foreach my $name (@names) {
    $cmd = $cmd . " " . $query->param($name);
}
print($cmd);
system($cmd);