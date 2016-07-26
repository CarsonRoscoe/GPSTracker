package test;

/*---------------------------------------------------------------------------------------
--	Source File:		tcps.java - A simple (multi-threaded) Java TCP echo server
--
--	Classes:		tcps - public class
--				ServerSocket - java.net
--				Socket	     - java.net
--				
--	Methods:
--				getRemoteSocketAddress 	(Socket Class)
--				getLocalSocketAddress  	(Socket Class)
--				getInputStream		(Socket Class)
--				getOutputStream		(Socket Class)
--				getLocalPort		(ServerSocket Class)
--				setSoTimeout		(ServerSocket Class)
--				accept			(ServerSocket Class)
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
-- 	echo server.The server is multi-threaded so every new client connection is 
--	handled by a separate thread.
--	
--	The application receives a string from an echo client and simply sends back after 
--	displaying it. 
--
--	Generate the class file and run it as follows:
--			javac tcps
--			java tcps <server port>
---------------------------------------------------------------------------------------*/

import java.net.*;
import java.io.*;

public class tcps extends Thread {
	String ServerString;
	private ServerSocket ListeningSocket;

	public tcps(int port) throws IOException {
		ListeningSocket = new ServerSocket(port);
		ListeningSocket.setSoTimeout(20000); // set a 20 second timeout
	}

	public void run() {
		while (true) {
			try {
				// Listen for connections and accept
				System.out.println("Listening on port: " + ListeningSocket.getLocalPort());
				Socket NewClientSocket = ListeningSocket.accept();
				System.out.println("Connection from: " + NewClientSocket.getRemoteSocketAddress());

				// Get the client string
				DataInputStream in = new DataInputStream(NewClientSocket.getInputStream());
				System.out.println(ServerString = in.readUTF());

				// Echo it back
				DataOutputStream out = new DataOutputStream(NewClientSocket.getOutputStream());
				out.writeUTF(ServerString + NewClientSocket.getLocalSocketAddress());
				NewClientSocket.close();
			}

			catch (SocketTimeoutException s) {
				System.out.println("Socket timed out!");
				break;
			}

			catch (IOException e) {
				e.printStackTrace();
				break;
			}
		}
	}

	public static void main(String[] args) {
		if (args.length != 1) {
			System.out.println("Usage Error : java jserver <port>");
			System.exit(0);
		}
		int port = Integer.parseInt(args[0]);

		try {
			Thread t = new tcps(port);
			t.start();
		}

		catch (IOException e) {
			e.printStackTrace();
		}
	}
}