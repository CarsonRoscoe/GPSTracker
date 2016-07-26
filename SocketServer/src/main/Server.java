package main;

import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

public class Server {
	
	// JDBC driver name and database URL
	static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";
	static final String DB_URL = "jdbc:mysql://localhost:3306/gpstracker";

	// Database credentials
	static final String USER = "root";
	static final String PASS = "comp4985cmst";
	
	static final DateFormat DATE_FORMAT = new SimpleDateFormat("yyyy/MM/dd-HH:mm:ss");

    /**
     * METHOD: main
     *
     * INTERFACE: void main(String[] args
     *
     * DATE: March 20th, 2016
     *
     * REVISIONS: March 20th, 2016
     *
     * @programmer: Spenser Lee
     *
     * @designer: Spenser Lee
     *
     * NOTES: Entry point of program
     */
	public static void main(String[] args) {
		
		System.out.println(Server.getDateTime() + "server started:" + ServerThread.LIST_PORT);
		Thread t;
		try {
			t = new ServerThread();
			t.start();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
    /**
     * METHOD: getDateTime
     *
     * INTERFACE: String getDateTime()
     *
     * DATE: March 20th, 2016
     *
     * REVISIONS: March 20th, 2016
     *
     * @programmer: Spenser Lee
     *
     * @designer: Spenser Lee
     *
     * NOTES: Get current time string.
     */
	public static String getDateTime() {
		Date date = new Date();
		return "[" + DATE_FORMAT.format(date) + "] ";
	}
	
    /**
     * METHOD: writeToDB
     *
     * INTERFACE: writeToDB(String user, String ip, String deviceName, String deviceId, String latitude, String longitude)
     *
     * DATE: March 20th, 2016
     *
     * REVISIONS: March 20th, 2016
     *
     * @programmer: Spenser Lee
     *
     * @designer: Spenser Lee
     *
     * NOTES: Writes the client position to DB.
     */
	public static boolean writeToDB(String user, String ip, String deviceName, String deviceId, String latitude, String longitude) {
		Connection conn = null;
		Statement stmt = null;
		ResultSet result = null;
		try {
			// TODO: print error messages...
			
			conn = DriverManager.getConnection(DB_URL, USER, PASS);
			stmt = conn.createStatement();
			
			String sql = "SELECT COUNT(`username`) AS rowcount FROM clientposition WHERE `datetime` = NOW()";
			
			result = stmt.executeQuery(sql);
			
			// don't insert if identical time stamp
			result.next();
		    if (result.getInt("rowcount") > 0) {
		    	return false;
		    }
			
			sql = "SELECT COUNT(`username`) AS rowcount FROM clientposition WHERE `username` = "
					+ "'" + user + "' AND `latitude` = " + latitude + " AND `longitude` = " + longitude;
			
			result = stmt.executeQuery(sql);
			
			// don't insert if identical location
			result.next();
		    if (result.getInt("rowcount") > 0) {
		    	return false;
		    }

			sql = "INSERT INTO `clientposition` "
					+ "(`username`, `datetime`, `ip`, `deviceName`, `deviceId`, `latitude`, `longitude`) "
					+ "VALUES ('" + user + "', CURRENT_TIMESTAMP, '" + ip + "', '" + deviceName + "', '" 
					+ deviceId + "', '" + latitude + "', '" + longitude + "');";
			stmt.executeUpdate(sql);
					
			// for log file
			System.out.println(getDateTime() + user + ":" + ip + ":" + deviceId + ":" + latitude + ":" + longitude);
			
			//TODO: catch MySQLIntegrityConstraintViolationException duplicates

		} catch (SQLException se) {
			// Handle errors for JDBC
			se.printStackTrace();
			return false;
		} catch (Exception e) {
			// Handle errors for Class.forName
			e.printStackTrace();
			return false;
			
		} finally {
			// finally block used to close resources
			try {
				if (stmt != null) {
					conn.close();
					return true;
				}
			} catch (SQLException se) {
				return false;
			}
			try {
				if (conn != null) {
					conn.close();
					return true;
				}
			} catch (SQLException se) {
				se.printStackTrace();
				return false;
			}
		}
		return true;
	}

}
