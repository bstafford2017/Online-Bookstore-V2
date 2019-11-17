#!/usr/bin/perl
use strict;
use warnings;
use CGI; 
my $query = new CGI;
my $title = $query->param('title');
my $price = $query->param('price');
my $isbn = $query->param('isbn');
my $subjects = $query->param('subjects');

if(!defined $title && !defined $price && !defined $isbn && !defined $subjects){
    exit(0);
}

print("Content-type: text/html\n\n");

#$title =~ s/^\s*(\S*)\s*$/$1/;
#$title =~ s/;|>|>>|<|\*|\?|\&|\|//g;
$price =~ s/^\s*(\S*)\s*$/$1/;
$price =~ s/;|>|>>|<|\*|\?|\&|\|//g;
$isbn =~ s/^\s*(\S*)\s*$/$1/;
$isbn =~ s/;|>|>>|<|\*|\?|\&|\|//g;
#$allSubjects =~ s/^\s*(\S*)\s*$/$1/;
#$allSubjects =~ s/;|>|>>|<|\*|\?|\&|\|//g;
# Test later if put in this code above
my $compile = "/usr/bin/javac Create.java";
system($compile);

my $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Create ";
$cmd = $cmd . " " . $isbn . " " . $title . " " . $price . " " . $subjects;
system($cmd);
print($cmd);