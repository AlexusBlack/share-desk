/*
 * Created by SharpDevelop.
 * User: Admin
 * Date: 10.12.2010
 * Time: 13:07
 * 
 * To change this template use Tools | Options | Coding | Edit Standard Headers.
 */
using System;
using System.Collections.Generic;
using System.Drawing;
using System.Drawing.Drawing2D;
using System.Drawing.Imaging;
using System.Net;
using System.Windows.Forms;
using JCS;

namespace WebDesk
{
	/// <summary>
	/// Description of MainForm.
	/// </summary>
	public partial class MainForm : Form
	{
		string baseurl="http://sharedesk.a-l-e-x-u-s.ru/";
		int id;
		string key;
		Form1 settings=new Form1();
		int xsize=800;
		int quality=85;
		
		public string[] GetVals(string src) {
			string[] str=src.Split('\n');
			string[] val=str[0].Split('=');			
			string[] vals=new string[2];
			vals[0] = val[1];
			val=str[1].Split('=');
			vals[1] = val[1];
			return vals;			
		}
		private static Image resizeImage(Image imgToResize, Size size) {
   			int sourceWidth = imgToResize.Width;
   			int sourceHeight = imgToResize.Height;

   			float nPercent = 0;
   			float nPercentW = 0;
   			float nPercentH = 0;

   			nPercentW = ((float)size.Width / (float)sourceWidth);
   			nPercentH = ((float)size.Height / (float)sourceHeight);

  			if (nPercentH < nPercentW)
      			nPercent = nPercentH;
   			else
      			nPercent = nPercentW;

   			int destWidth = (int)(sourceWidth * nPercent);
   			int destHeight = (int)(sourceHeight * nPercent);

   			Bitmap b = new Bitmap(destWidth, destHeight);
   			Graphics g = Graphics.FromImage((Image)b);
   			g.InterpolationMode = InterpolationMode.HighQualityBicubic;

   			g.DrawImage(imgToResize, 0, 0, destWidth, destHeight);
   			g.Dispose();

   			return (Image)b;
		}
		private void saveJpeg(string path, Bitmap img, long quality) {
   			// Encoder parameter for image quality
  			 EncoderParameter qualityParam = new EncoderParameter(Encoder.Quality, quality);

   			// Jpeg image codec
   			ImageCodecInfo jpegCodec = this.getEncoderInfo("image/jpeg");

   			if(jpegCodec == null)
     			return;

   			EncoderParameters encoderParams = new EncoderParameters(1);
  			encoderParams.Param[0] = qualityParam;

   			img.Save(path, jpegCodec, encoderParams);
		}

		private ImageCodecInfo getEncoderInfo(string mimeType) {
   			// Get image codecs for all image formats
   			ImageCodecInfo[] codecs = ImageCodecInfo.GetImageEncoders();

  			 // Find the correct image codec
  			 for (int i = 0; i < codecs.Length; i++)
      			if (codecs[i].MimeType == mimeType)
        			 return codecs[i];
   				return null;
		}
		
		public Bitmap ScreenShot() {
   			Bitmap screenShotBMP = new Bitmap(Screen.PrimaryScreen.Bounds.Width,
        	Screen.PrimaryScreen.Bounds.Height, PixelFormat.Format32bppArgb);
    		Graphics screenShotGraphics = Graphics.FromImage(screenShotBMP);
    		screenShotGraphics.CopyFromScreen(Screen.PrimaryScreen.Bounds.X,
        	Screen.PrimaryScreen.Bounds.Y, 0, 0, Screen.PrimaryScreen.Bounds.Size,
        	CopyPixelOperation.SourceCopy);
    		screenShotGraphics.Dispose();
    		return screenShotBMP;
		}
		private int RandomNumber(int min, int max) {
			Random random = new Random();
			return random.Next(min, max);
		}
		WebClient con = new WebClient();
		public void Stage1() {
			string[] vars=GetVals(con.DownloadString(baseurl+"api.php?act=getkey"));
			id=Convert.ToInt32(vars[0]);
			key=vars[1];
			button1.Visible=false;
			button3.Visible=false;
			button2.Visible=true;
			timer1.Start();
			textBox1.Text=baseurl+"?key="+id.ToString();
		}
		public void Stage2() {
			//resizeImage(ScreenShot(), new Size(800,600)).Save("temp.png");
			//ScreenShot().Save("temp.png");
			saveJpeg("temp.jpg",(Bitmap)resizeImage(ScreenShot(), new Size(xsize,600)), quality);
			con.UploadFile(baseurl+"api.php?act=send2&id="+id.ToString()+"&key="+key, "temp.jpg");
		}
		public void Stage3() {
			con.DownloadString(baseurl+"api.php?act=close&id="+id.ToString()+"&key="+key);
			button1.Visible=true;
			button3.Visible=true;
			button2.Visible=false;
			timer1.Stop();			
		}
		public MainForm()
		{
			//
			// The InitializeComponent() call is required for Windows Forms designer support.
			//
			InitializeComponent();
			textBox1.Text=OSVersionInfo.Name;
			//
			// TODO: Add constructor code after the InitializeComponent() call.
			//
		}
		
		void Button1Click(object sender, EventArgs e)
		{
			Stage1();
		}
		
		void Button2Click(object sender, EventArgs e)
		{
			Stage3();
		}
		
		void Timer1Tick(object sender, EventArgs e)
		{
			Stage2();
		}
		
		void NotifyIcon1Click(object sender, System.EventArgs e)
		{
			if(this.Visible) {
				this.Visible=false;
			} else {
				this.Visible=true;
			}
		}
		
		void Button3Click(object sender, EventArgs e)
		{
			//MessageBox.Show("Alexander Chernov", "Author", 0, 0, 0, 0, false);
			settings.ShowDialog();
			baseurl=settings.base_url;
			timer1.Interval=settings.interval;
			xsize=settings.xsize;
			quality=settings.quality;
		}
	}
}
