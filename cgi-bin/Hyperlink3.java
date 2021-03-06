import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.LinkedList;

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
            LinkedList<String> list = new LinkedList<>();
            int counter = 0;
            while(rset.next()){
                if(!list.contains(rset.getString(4))){
                    if(counter == 0) {
                        System.out.println("<p>Name: " + rset.getString(1) + "</p><p>Username: " + rset.getString(2) + "</p><p>Password: " + rset.getString(3) + "</p><p>Purchases: ");
                    }
                    String purchaseData = "SELECT isbn, title, price FROM book b WHERE isbn = " + rset.getString(4);
                    ResultSet result = innerstmt.executeQuery(purchaseData);
                    while(result.next()){
                        System.out.print("<br/><br/>ISBN: " + result.getString(1) + "<br/>Title: " + result.getString(2) + "<br/>Price: $" + result.getString(3) + "<br/>Quantity: ");
                        CallableStatement cstmt = conn.prepareCall("{? = call quantity(?)}");
                        cstmt.registerOutParameter(1, Types.INTEGER);
                        cstmt.setLong(2, Long.parseLong(result.getString(1)));
                        cstmt.execute();
                        System.out.print(cstmt.getInt(1));
                        cstmt.close();
                    }
                    list.add(rset.getString(4));
                    result.close();
                    counter++;
                }
            }
            CallableStatement cstmt = conn.prepareCall("{? = call total(?)}");
            cstmt.registerOutParameter(1, Types.DOUBLE);
            cstmt.setString(2, args[0].trim());
            cstmt.execute();
            System.out.print("</br></br><b>Total Purchases: $" + cstmt.getDouble(1) + "</b>");
            cstmt.close();
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
