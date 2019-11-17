import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.Arrays;
import java.util.stream.Stream;

public class ListBooks {
    public static void main(String[] args) throws SQLException{
        String user     = "C##benjamin.stafford";
        String password = "stafford6248";
        String database = "65.52.222.73:1521/cdb1";
        OracleDataSource ods = new OracleDataSource();
        ods.setURL("jdbc:oracle:thin:@" + database);
        ods.setUser(user);
        ods.setPassword(password);
        Connection conn = ods.getConnection();
        try {
            Statement stmt = conn.createStatement();
            ResultSet rset = stmt.executeQuery("select isbn, title, price from book");
            int rowCounter = 0;
            while(rset.next()){
                System.out.println("<tr id=\"" + rowCounter + "\" scope=\"col\">");
                System.out.println("<td scope=\"col\"><input type=\"checkbox\" name=\"isbn\" value=\"" + rset.getString(1) + "\"/></td>");
                System.out.println("<td scope=\"col\"><a href=\"cgi-bin/hyperlink.cgi?isbn=" + rset.getString(1) + "\">" + rset.getString(2) + "</a></td>");
                System.out.println("<td scope=\"col\"><input type=\"text\" id=\"price\"value=\"" + rset.getString(3) + "\"/></td></tr>");
                rowCounter++;
            }
            if(rowCounter == 0){
                System.out.println("<td></td><td><center><h4>No results!</h4></center></td>");
            }
            rset.close();
            stmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        conn.close();
    }
}
