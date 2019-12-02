import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.Arrays;
import java.util.LinkedList;
import java.util.Iterator;
import java.util.Comparator;
import java.util.Collections;

public class Purchase {
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
            /*
                args[] = {username, isbn0, isbn1, ... }
            */
            String checkNull = "SELECT COLUMN_VALUE FROM customer c, table(c.purchases) WHERE username LIKE '" + args[0].trim() + "'";
            System.out.println("\n" + checkNull);
            ResultSet rset = stmt.executeQuery(checkNull);
            int counter = 0;
            if(rset.next()){
                counter++;
            }
            if(counter == 0){
                String update = "UPDATE customer c SET c.purchases = NEW purchases_list() WHERE username LIKE '" + args[0].trim() + "'";
                stmt.executeUpdate(update);
                System.out.println("\n" + update);
            }
            for(int i = 1; i < args.length; i++){
                String query = "INSERT INTO table(SELECT purchases FROM customer WHERE username LIKE '" + args[0].trim() + "') VALUES (" + args[i].trim() + ")";
                System.out.println(query);
                stmt.executeUpdate(query);
            }
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        stmt.close();
        conn.close();
    }
}
