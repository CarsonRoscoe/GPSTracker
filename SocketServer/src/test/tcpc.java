package test;

/*---------------------------------------------------------------------------------------
--	Source File:		tcpc.java - A simple Java TCP echo client
--
--	Classes:		tcpc - public class
--				Socket - java.net
--				
--	Methods:
--				getRemoteSocketAddress 	(Socket Class)
--				getLocalSocketAddress  	(Socket Class)
--				getInputStream		(Socket Class)
--				getOutputStream		(Socket Class)
--				
--
--	Date:			February 8, 2014
--
--	Revisions:		(Date and Description)
--					
--	Designer:		Aman Abdulla
--				
--	Programmer:		Aman Abdulla
--
--	Notes:
--	The program illustrates the use of the java.net package to implement a basic
-- 	echo client. 
--	
--	The application takes a user-supplied string from commnad line and sends it to 
--	a echo server, then waits for the echo and displays it. 
--
--	Generate the class file and run it as follows:
--			javac tcpc
--			java <server address> <destination port>
---------------------------------------------------------------------------------------*/

import java.net.*;
import java.io.*;

public class tcpc {
	public static void main(String[] args) {
		String ClientString;

		if (args.length != 2) {
			System.out.println("Usage Error : java jclient <host> <port>");
			System.exit(0);
		}
		String serverName = args[0];
		int port = Integer.parseInt(args[1]);

		try {
			// Connect to the server
			System.out.println("Connecting to " + serverName + " on port " + port);
			Socket client = new Socket(serverName, port);
			System.out.println("Successful connection to: " + client.getRemoteSocketAddress());

			// Get console input
			BufferedReader input = new BufferedReader(new InputStreamReader(System.in));
			ClientString = input.readLine();

			// Send client string to server
			OutputStream outToServer = client.getOutputStream();
			DataOutputStream out = new DataOutputStream(outToServer);
			out.writeUTF(ClientString + client.getLocalSocketAddress());
			InputStream inFromServer = client.getInputStream();

			// Get the echo from server
			DataInputStream in = new DataInputStream(inFromServer);
			System.out.println("Server Echo: " + in.readUTF());
			client.close();
		}

		catch (IOException e) {
			e.printStackTrace();
		}
	}
}