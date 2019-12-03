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
            String query = "";

            Boolean admin = ListCustomers.isAdmin(args[0].trim(), stmt);
            
            query += "SELECT admin, c_name, username, pwd FROM customer c, table(c.purchases)";
            
            // If not admin, add WHERE to specify username
            if(!admin){
                query += " WHERE username LIKE '%" + args[0].trim() + "%'";
            }
            System.out.println(query);
            ResultSet resultSet = stmt.executeQuery(query);
            int rowCounter = 0;
            while(resultSet.next()){
                System.out.println("<tr id=\"" + rowCounter + "\" scope=\"col\">");
                System.out.println("<td scope=\"col\">" + resultSet.getString(2) + "</td>");
                System.out.println("<td scope=\"col\"><a href=\"cgi-bin/hyperlink.cgi?username=" + resultSet.getString(3).replace(" ", "+") + "\" style=\"color: white;\">" + resultSet.getString(3) + "</a></td>");
                System.out.println("<td scope=\"col\">" + resultSet.getString(4) + "</td>");
                if(resultSet.getString(1).equals("1")){
                    System.out.println("<td scope=\"col\">Yes</td>");
                } else {
                    System.out.println("<td scope=\"col\">No</td>");
                }
                System.out.println("</tr>");
                rowCounter++;
            }
            System.out.println(list.toString());
            if(rowCounter == 0){
                System.out.println("<td></td><td></td><td><center><h4>No results!</h4></center></td>");
            }
            resultSet.close();
            stmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        conn.close();
    }

    public static boolean isAdmin(String username, Statement stmt){
        try{
            ResultSet set = stmt.executeQuery("SELECT c_admin FROM customer WHERE username LIKE '%" + username + "%'");
            if(set.next()){
                if(set.getString(1).equals("1")){
                    return true;
                } else {
                    return false;
                }
            }
        } catch (SQLException ex) {
            System.out.println(ex);
        }
        return false;
    }
}
