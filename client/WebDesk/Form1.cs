/*
 * Created by SharpDevelop.
 * User: Admin
 * Date: 14.12.2010
 * Time: 16:40
 * 
 * To change this template use Tools | Options | Coding | Edit Standard Headers.
 */
using System;
using System.Drawing;
using System.Windows.Forms;

namespace WebDesk
{
	/// <summary>
	/// Description of Form1.
	/// </summary>
	public partial class Form1 : Form
	{
		public Form1()
		{
			//
			// The InitializeComponent() call is required for Windows Forms designer support.
			//
			InitializeComponent();
			
			//
			// TODO: Add constructor code after the InitializeComponent() call.
			//
		}
		public string base_url="http://sharedesk.a-l-e-x-u-s.ru/";
		public int interval=3000;
		public int xsize=800;
		public int quality=85;
		void Button1Click(object sender, EventArgs e)
		{
			base_url=textBox2.Text;
			interval=Convert.ToInt32(textBox1.Text+"000");
			xsize=Convert.ToInt32(textBox3.Text);
			quality=Convert.ToInt32(textBox4.Text);
			
			this.Close();
		}
		
		void Button2Click(object sender, EventArgs e)
		{
			MessageBox.Show("Alexander Chernov", "Author", 0, 0, 0, 0, false);
		}
	}
}
