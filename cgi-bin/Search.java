import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.Arrays;
import java.util.LinkedList;
import java.util.Iterator;
import java.util.Comparator;
import java.util.Collections;

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
            String query = "SELECT COUNT(*), isbn, title, price, COLUMN_VALUE FROM book b, table(b.subjects) ";
            for(int i = 0; i < args.length; i++){
                if(i == 0){
                    query += "WHERE lower(COLUMN_VALUE) IN (";
                }
                if(i == args.length - 1){
                    query += "'" + args[i].trim().toLowerCase() + "') GROUP BY isbn, title, price, COLUMN_VALUE ORDER BY COUNT(*) DESC";
                } else {
                    query += "'" + args[i].trim().toLowerCase() + "',";
                }
            }
            if(args.length == 0){
                query += "GROUP BY isbn, title, price, COLUMN_VALUE";
            }
            ResultSet rset = stmt.executeQuery(query);
            int counter = 0;
            while(rset.next()){
                System.out.println("<tr scope=\"col\">");
                System.out.println("<td scope=\"col\"><input type=\"checkbox\" value=\"" + rset.getString(2) + "\"/></td>");
                System.out.println("<td id=\"count\">" + rset.getString(1) + "</td>");
                System.out.println("<td id=\"isbn\">" + rset.getString(2) + "</td>");
                System.out.println("<td id=\"title\" scope=\"col\"><a href=\"cgi-bin/hyperlink.cgi?isbn=" + rset.getString(2) + "\" style=\"color: white\">" + rset.getString(3) + "</a></td>");
                System.out.println("<td id=\"price\" scope=\"col\">" + rset.getString(4) + "</td>");
                System.out.println("<td id=\"subject\" scope=\"col\"><a href=\"cgi-bin/hyperlink.cgi?subjects=" + rset.getString(5) + "\" style=\"color: white;\">" + rset.getString(5) + "</a></td></tr>");
                counter++;
            }
            if(counter == 0){
                System.out.println("<td></td><td></td><td><center><h4>No results!</h4></center></td>");
            }
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        stmt.close();
        conn.close();
    }
}
