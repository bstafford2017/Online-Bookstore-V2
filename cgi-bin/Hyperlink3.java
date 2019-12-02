import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;

public class Hyperlink3 {
    public static void main(String[] args) throws SQLException {
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
            Statement innerstmt = conn.createStatement();
            String query = "SELECT c_name, username, pwd, COLUMN_VALUE FROM customer c, table(c.purchases)(+) WHERE username LIKE '%" + args[0].trim().toLowerCase() + "%'";
            ResultSet rset = stmt.executeQuery(query);
            int counter = 0;
            while(rset.next()){
                if(counter == 0) {
                    System.out.println("<p>Name: " + rset.getString(1) + "</p><p>Username: " + rset.getString(2) + "</p><p>Password: " + rset.getString(3) + "</p><p>Purchases: ");
                }
                String purchaseData = "SELECT isbn, title, price FROM book b WHERE isbn = " + rset.getString(4);
                ResultSet result = innerstmt.executeQuery(purchaseData);
                while(result.next()){
                    System.out.println("<br/><br/>ISBN: " + result.getString(1) + "<br/>Title: " + result.getString(2) + "<br/>Price: " + result.getString(3) + "<br/>");
                }
                result.close();
                counter++;
            }
            System.out.println("</p>");
            rset.close();
            stmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        conn.close();
    }
}
