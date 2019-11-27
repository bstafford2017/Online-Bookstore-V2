import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.Arrays;
import java.util.stream.Stream;

public class Create {
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
            /* Each have a value
               Assumed order is: {isbn, title, price, subject1, subject2, ...} */
            
            // Insert into books table
            args[1] = args[1].replaceAll("-", " ");
            for(int i = 3; i < args.length; i++){
                args[i] = args[i].replaceAll("-", " ");
            }

            // Insert into books table
            String insertBook = "INSERT INTO book (isbn, title, price, subjects) VALUES (" + args[0].trim() +", '" + args[1].trim() + "', " + args[2].trim() + ", ";
            if(args.length == 3){
                insertBook += "NULL)";
            } else {
                insertBook += "subject_table(";
                for(int i = 3; i < args.length; i++){
                    insertBook += args[i].trim();
                }
                insertBook += ")";
            }
            stmt.executeQuery(insertBook);

            stmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        conn.close();
    }
}
