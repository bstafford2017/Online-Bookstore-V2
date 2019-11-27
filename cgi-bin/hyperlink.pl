#!/usr/bin/perl
use strict;
use warnings;
use CGI; 
my $query = new CGI;
my $isbn = $query->param('isbn');
my $subjects = $query->param('subjects');

print("Content-type: text/html\n\n");
print("<!doctype html><head></head><body>");
my $cmd = "";

if(defined $isbn){
    my $compile = "/usr/bin/javac Hyperlink.java";
    system($compile);

    $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Hyperlink ";
    $cmd = $cmd . $isbn;
}

if(defined $subjects){
    my $compile = "/usr/bin/javac Hyperlink2.java";
    system($compile);
    
    $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Hyperlink2 ";
    $cmd = $cmd . $subjects;
}
if(!defined $isbn && !defined $subjects){
    print("<p>No Result</p></body></html>");
    exit(0);
}
system($cmd);
print("</body></html>");