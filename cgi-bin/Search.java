import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.Arrays;
import java.util.LinkedList;
import java.util.Iterator;
import java.util.Comparator;
import java.util.Collections;

class Tuple {
    int count;
    long isbn;
    String title;
    double price;
    LinkedList<String> subjects = new LinkedList<>();

    public Tuple(int count, long isbn, String title, double price, String subject){
        this.count = count;
        this.isbn = isbn;
        this.title = title;
        this.price = price;
        this.subjects.add(subject);
    }
}

public class Search {
    public static void main(String[] args) throws SQLException {
        String user     = "C##benjamin.stafford";
        String password = "stafford6248";
        String database = "65.52.222.73:1521/cdb1";
        OracleDataSource ods = new OracleDataSource();
        ods.setURL("jdbc:oracle:thin:@" + database);
        ods.setUser(user);
        ods.setPassword(password);
        Connection conn = ods.getConnection();
        Statement stmt = conn.createStatement();
        try {
            LinkedList<Tuple> list = new LinkedList<>();
            String query = "select book.isbn, book.title, book.price, subject.subject_name from book join subjects on book.isbn = subjects.isbn join subject on subject.subject_id = subjects.s_id ";
            // Add all subjects to be 'OR'ed in query
            for(int i = 0; i < args.length; i++){
                if(i == 0){
                    query += "where";
                }
                query = query + " subject.subject_name like '%" + args[i].trim().replace("-", " ") + "%' ";
                if(i < args.length - 1){
                    query += " or ";
                }
            }
            // Get the data from search query
            ResultSet rset = stmt.executeQuery(query);
            while(rset.next()){
                System.out.println(Search.isbnAlreadyInList(list, rset.getString(4), Long.parseLong(rset.getString(1))));
                if(!Search.isbnAlreadyInList(list, rset.getString(4), Long.parseLong(rset.getString(1)))){
                    list.add(new Tuple(1, Long.parseLong(rset.getString(1)), rset.getString(2), Double.parseDouble(rset.getString(3)), rset.getString(4)));
                }
            }
            Collections.sort(list, new Comparator<Tuple>(){
                @Override
                public int compare(Tuple t1, Tuple t2){
                    return t2.count - t1.count;
                }
            });
            rset.close();
            if(list.size() == 0){
                System.out.println("<td></td><td></td><td><center><h4>No results!</h4></center></td>");
                System.exit(0);
            }
            Iterator<Tuple> it = list.iterator();
            while(it.hasNext()){
                Tuple current = it.next();
                System.out.println("<tr scope=\"col\">");
                System.out.println("<td id=\"count\">" + current.count + "</td>");
                System.out.println("<td id=\"isbn\">" + current.isbn + "</td>");
                System.out.println("<td id=\"title\" scope=\"col\"><a href=\"cgi-bin/hyperlink.cgi?isbn=" + current.isbn + "\">" + current.title + "</a></td>");
                System.out.println("<td id=\"price\" scope=\"col\">" + current.price + "</td>");
                Iterator<String> ito = current.subjects.iterator();
                System.out.println("<td id=\"subjects\" scope=\"col\">");
                while(ito.hasNext()){
                    String str = ito.next();
                    System.out.println("<a href=\"cgi-bin/hyperlink.cgi?subjects=" + str.replace(" ", "-") + "\">" + str + "</a> ");
                }
                System.out.println("</td></tr>");
            }
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        stmt.close();
        conn.close();
    }

    // True = do not add to list (already in)
    // False = add to list (not in list yet)
    // Increments count if found in list
    public static boolean isbnAlreadyInList(LinkedList<Tuple> list, String subject, long isbn){
        // Check if 'subject' is in list
        Iterator<Tuple> it = list.iterator();
        while(it.hasNext()){
            Tuple current = it.next();
            if(current.isbn == isbn){
                if(!current.subjects.contains(subject)){
                    current.subjects.add(subject);
                }
                current.count += 1;
                return true;
            }
        }
        return false;
    }
}
