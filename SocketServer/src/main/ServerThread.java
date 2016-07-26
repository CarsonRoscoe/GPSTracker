package main;

import java.io.DataInputStream;
import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.SocketTimeoutException;

import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;


public class ServerThread extends Thread {
	
	static final int LIST_PORT = 4985;
	
	String retMsg;
	private ServerSocket listenSock;
	
	public ServerThread() throws IOException {
		listenSock = new ServerSocket(LIST_PORT);
//		listenSock.setSoTimeout(20000); // 20 sec
	}
	
    /**
     * METHOD: run
     *
     * INTERFACE: void run()
     *
     * DATE: March 20th, 2016
     *
     * REVISIONS: March 20th, 2016
     *
     * @programmer: Spenser Lee
     *
     * @designer: Spenser Lee
     *
     * NOTES: Thread function to process incoming client connections.
     */
	public void run() {
		JSONParser parser = new JSONParser();
		
		while (true) {
			try {
				// listen for and accept new connections
				Socket clientSock = listenSock.accept();
				String clientIp = clientSock.getRemoteSocketAddress().toString();
				
				// get incoming data string
				DataInputStream in = new DataInputStream(clientSock.getInputStream());
				retMsg = in.readUTF();
				
				Object obj = parser.parse(retMsg);
				JSONObject jsonobj = (JSONObject)obj;
				
				clientIp = clientIp.substring(1, clientIp.indexOf(':'));
				
				String ip 			= clientIp;
				String name 		= jsonobj.get("name").toString();
				String deviceId 	= jsonobj.get("deviceId").toString();
				String deviceName 	= jsonobj.get("deviceName").toString();
				String latitude 	= jsonobj.get("latitude").toString();
				String longitude 	= jsonobj.get("longitude").toString();
				
				// write to DB here
				if (!latitude.equalsIgnoreCase("---") && !longitude.equalsIgnoreCase("---")) {
					Server.writeToDB(name, ip, deviceName, deviceId, latitude, longitude);
				}
				
				clientSock.close();
			} catch (SocketTimeoutException s) {
				System.out.println(Server.getDateTime() + " socket timeout");
				break;
			} catch (Exception e) {
				e.printStackTrace();
				break;
			}
		}
	}
	
}
