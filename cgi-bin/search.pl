#!/usr/bin/perl
use strict;
use warnings;
use CGI; 
my $query = new CGI;
my $subject = $query->param('subject');

print("Content-type: text/html\n\n");
my $compile = "/usr/bin/javac Search.java";
system($compile);
my $cmd = "";
if(!defined $subject){
    $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Search ";
} else {
    $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Search " . $subject;
}
system($cmd);
