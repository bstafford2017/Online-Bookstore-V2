#!/usr/bin/perl
use strict;
use warnings;
use CGI; 
my $query = new CGI;
my $search = $query->param('isbn');

print("Content-type: text/html\n\n");
my $compile = "/usr/bin/javac Purchase.java";
system($compile);
my $cmd = "";
if(!defined $search){
    $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Purchase ";
    system($cmd);
}
