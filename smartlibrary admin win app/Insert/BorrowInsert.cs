using MySql.Data.MySqlClient;
using System;
using System.Windows.Forms;

namespace smartlibrary.Insert
{
    public partial class BorrowInsert : Form
    {
        string connectionString = "server=localhost;user id=root;password=;database=librarySystem";

        public BorrowInsert()
        {
            InitializeComponent();
        }

        private void BorrowInsert_Load(object sender, EventArgs e)
        {
            ClearFields();
        }

        private void ClearFields()
        {
            txtStuNo.Clear();
            txtbId.Clear();
            txtName.Clear();
            txtEmail.Clear();
            txtContact.Clear();
            txtBookName.Clear();
            txtCategory.Clear();
        }

        private void btnClear_Click(object sender, EventArgs e)
        {
            ClearFields();
        }

        private void guna2CircleButton1_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void btnSave_Click(object sender, EventArgs e)
        {
            if (string.IsNullOrWhiteSpace(txtName.Text) || string.IsNullOrWhiteSpace(txtBookName.Text))
            {
                guna2MessageDialog1.Show("Please fill in all required fields.");
                return;
            }

            try
            {
                using (MySqlConnection conn = new MySqlConnection(connectionString))
                {
                    conn.Open();

                    // 1. Check if the book is already borrowed
                    string checkStatusQry = "SELECT status FROM book WHERE bid = @bid";
                    using (MySqlCommand checkCmd = new MySqlCommand(checkStatusQry, conn))
                    {
                        checkCmd.Parameters.AddWithValue("@bid", txtbId.Text);
                        object statusObj = checkCmd.ExecuteScalar();

                        if (statusObj != null && statusObj.ToString() == "Borrowed")
                        {
                            guna2MessageDialog1.Show("This book is already borrowed and cannot be borrowed again until returned.");
                            return; // Stop the borrowing process
                        }
                    }

                    // 2. Insert the borrowing record
                    string insertQry = "INSERT INTO borrow (sregno, bid, bname, email, contact, category, date) VALUES (@sregno, @bid, @bname, @email, @contact, @category, @date)";
                    using (MySqlCommand cmd = new MySqlCommand(insertQry, conn))
                    {
                        cmd.Parameters.AddWithValue("@sregno", txtStuNo.Text);
                        cmd.Parameters.AddWithValue("@bid", txtbId.Text);
                        cmd.Parameters.AddWithValue("@bname", txtBookName.Text);
                        cmd.Parameters.AddWithValue("@email", txtEmail.Text);
                        cmd.Parameters.AddWithValue("@contact", txtContact.Text);
                        cmd.Parameters.AddWithValue("@category", txtCategory.Text);
                        cmd.Parameters.AddWithValue("@date", DateTime.Now.ToString("yyyy-MM-dd"));

                        cmd.ExecuteNonQuery();
                    }

                    // 3. Update the book's status to 'Borrowed'
                    string updateQry = "UPDATE book SET status = 'Borrowed' WHERE bid = @bid";
                    using (MySqlCommand cmd2 = new MySqlCommand(updateQry, conn))
                    {
                        cmd2.Parameters.AddWithValue("@bid", txtbId.Text);
                        cmd2.ExecuteNonQuery();
                    }

                    guna2MessageDialog1.Show("Borrow details inserted successfully!");
                    ClearFields();
                }
            }
            catch (Exception ex)
            {
                guna2MessageDialog1.Show("Error: " + ex.Message);
            }
        }

        private void txtStuNo_TextChanged(object sender, EventArgs e)
        {
            try
            {
                using (MySqlConnection conn = new MySqlConnection(connectionString))
                {
                    conn.Open();

                    string query = "SELECT name, email, contact FROM user_form WHERE regno = @regno";
                    using (MySqlCommand cmd = new MySqlCommand(query, conn))
                    {
                        cmd.Parameters.AddWithValue("@regno", txtStuNo.Text);
                        using (MySqlDataReader reader = cmd.ExecuteReader())
                        {
                            if (reader.Read())
                            {
                                txtName.Text = reader["name"].ToString();
                                txtEmail.Text = reader["email"].ToString();
                                txtContact.Text = reader["contact"].ToString();
                            }
                            else
                            {
                                txtName.Clear();
                                txtEmail.Clear();
                                txtContact.Clear();
                            }
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                guna2MessageDialog1.Show("Error: " + ex.Message);
            }
        }

        private void txtbId_TextChanged(object sender, EventArgs e)
        {
            try
            {
                using (MySqlConnection conn = new MySqlConnection(connectionString))
                {
                    conn.Open();

                    string query = "SELECT bname, category FROM book WHERE bid = @bid";
                    using (MySqlCommand cmd = new MySqlCommand(query, conn))
                    {
                        cmd.Parameters.AddWithValue("@bid", txtbId.Text);
                        using (MySqlDataReader reader = cmd.ExecuteReader())
                        {
                            if (reader.Read())
                            {
                                txtBookName.Text = reader["bname"].ToString();
                                txtCategory.Text = reader["category"].ToString();
                            }
                            else
                            {
                                txtBookName.Clear();
                                txtCategory.Clear();
                            }
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                guna2MessageDialog1.Show("Error: " + ex.Message);
            }
        }

        private void lblsName_Click(object sender, EventArgs e)
        {
            // (Optional) Handle label click event if needed
        }

        private void guna2Panel1_Paint(object sender, PaintEventArgs e)
        {

        }
    }
}
