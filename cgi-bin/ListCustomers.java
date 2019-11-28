import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.Arrays;
import java.util.stream.Stream;

public class ListCustomers {
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
            ResultSet rset = stmt.executeQuery("SELECT c_name, username, pwd, COLUMN_VALUE FROM customer c, table(c.purchases)");
            int rowCounter = 0;
            while(rset.next()){
                System.out.println("<tr id=\"" + rowCounter + "\" scope=\"col\">");
                System.out.println("<td scope=\"col\">" + rset.getString(1) + "</td>");
                System.out.println("<td scope=\"col\">" + rset.getString(2) + "</td>");
                System.out.println("<td scope=\"col\">" + rset.getString(3) + "</td></tr>");
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
