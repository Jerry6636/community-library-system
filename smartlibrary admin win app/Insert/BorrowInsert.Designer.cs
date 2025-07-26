namespace smartlibrary.Insert
{
    partial class BorrowInsert
    {
        private System.ComponentModel.IContainer components = null;

        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        private void InitializeComponent()
        {
            this.txtStuNo = new Guna.UI2.WinForms.Guna2TextBox();
            this.txtbId = new Guna.UI2.WinForms.Guna2TextBox();
            this.txtName = new Guna.UI2.WinForms.Guna2TextBox();
            this.txtEmail = new Guna.UI2.WinForms.Guna2TextBox();
            this.txtContact = new Guna.UI2.WinForms.Guna2TextBox();
            this.txtBookName = new Guna.UI2.WinForms.Guna2TextBox();
            this.txtCategory = new Guna.UI2.WinForms.Guna2TextBox();
            this.btnSave = new Guna.UI2.WinForms.Guna2GradientButton();
            this.btnClear = new Guna.UI2.WinForms.Guna2GradientButton();
            this.guna2CircleButton1 = new Guna.UI2.WinForms.Guna2CircleButton();
            this.guna2Panel1 = new Guna.UI2.WinForms.Guna2Panel();
            this.label1 = new System.Windows.Forms.Label();
            this.guna2MessageDialog1 = new Guna.UI2.WinForms.Guna2MessageDialog();

            // 
            // guna2Panel1
            // 
            this.guna2Panel1.Controls.Add(this.label1);
            this.guna2Panel1.Controls.Add(this.guna2CircleButton1);
            this.guna2Panel1.Location = new System.Drawing.Point(0, 0);
            this.guna2Panel1.Name = "guna2Panel1";
            this.guna2Panel1.Size = new System.Drawing.Size(400, 60);
            // 
            // label1
            // 
            this.label1.Text = "Insert Borrow Details";
            this.label1.Font = new System.Drawing.Font("Segoe UI", 14F, System.Drawing.FontStyle.Bold);
            this.label1.ForeColor = System.Drawing.Color.Black;
            this.label1.Location = new System.Drawing.Point(100, 15);
            this.label1.Size = new System.Drawing.Size(220, 30);
            // 
            // guna2CircleButton1
            // 
            this.guna2CircleButton1.Text = "X";
            this.guna2CircleButton1.FillColor = System.Drawing.Color.Red;
            this.guna2CircleButton1.ForeColor = System.Drawing.Color.White;
            this.guna2CircleButton1.Font = new System.Drawing.Font("Segoe UI", 9F, System.Drawing.FontStyle.Bold);
            this.guna2CircleButton1.Location = new System.Drawing.Point(360, 10);
            this.guna2CircleButton1.Size = new System.Drawing.Size(30, 30);
            this.guna2CircleButton1.Click += new System.EventHandler(this.guna2CircleButton1_Click);
            // 
            // txtStuNo
            // 
            this.txtStuNo.PlaceholderText = "User id no.";
            this.txtStuNo.Location = new System.Drawing.Point(30, 80);
            this.txtStuNo.Name = "txtStuNo";
            this.txtStuNo.Size = new System.Drawing.Size(340, 36);
            this.txtStuNo.TextChanged += new System.EventHandler(this.txtStuNo_TextChanged);
            // 
            // txtbId
            // 
            this.txtbId.PlaceholderText = "Book ID";
            this.txtbId.Location = new System.Drawing.Point(30, 130);
            this.txtbId.Name = "txtbId";
            this.txtbId.Size = new System.Drawing.Size(340, 36);
            this.txtbId.TextChanged += new System.EventHandler(this.txtbId_TextChanged);
            // 
            // txtName
            // 
            this.txtName.PlaceholderText = "User Name";
            this.txtName.Location = new System.Drawing.Point(30, 180);
            this.txtName.Name = "txtName";
            this.txtName.Size = new System.Drawing.Size(340, 36);
            // 
            // txtEmail
            // 
            this.txtEmail.PlaceholderText = "Email";
            this.txtEmail.Location = new System.Drawing.Point(30, 230);
            this.txtEmail.Name = "txtEmail";
            this.txtEmail.Size = new System.Drawing.Size(340, 36);
            // 
            // txtContact
            // 
            this.txtContact.PlaceholderText = "Contact";
            this.txtContact.Location = new System.Drawing.Point(30, 280);
            this.txtContact.Name = "txtContact";
            this.txtContact.Size = new System.Drawing.Size(340, 36);
            // 
            // txtBookName
            // 
            this.txtBookName.PlaceholderText = "Book Name";
            this.txtBookName.Location = new System.Drawing.Point(30, 330);
            this.txtBookName.Name = "txtBookName";
            this.txtBookName.Size = new System.Drawing.Size(340, 36);
            // 
            // txtCategory
            // 
            this.txtCategory.PlaceholderText = "Category";
            this.txtCategory.Location = new System.Drawing.Point(30, 380);
            this.txtCategory.Name = "txtCategory";
            this.txtCategory.Size = new System.Drawing.Size(340, 36);
            // 
            // btnSave
            // 
            this.btnSave.Text = "Save";
            this.btnSave.Location = new System.Drawing.Point(60, 440);
            this.btnSave.Size = new System.Drawing.Size(120, 40);
            this.btnSave.Click += new System.EventHandler(this.btnSave_Click);
            // 
            // btnClear
            // 
            this.btnClear.Text = "Clear";
            this.btnClear.Location = new System.Drawing.Point(220, 440);
            this.btnClear.Size = new System.Drawing.Size(120, 40);
            this.btnClear.Click += new System.EventHandler(this.btnClear_Click);

            // 
            // BorrowInsert (Form)
            // 
            this.ClientSize = new System.Drawing.Size(400, 510);
            this.Controls.Add(this.guna2Panel1);
            this.Controls.Add(this.txtStuNo);
            this.Controls.Add(this.txtbId);
            this.Controls.Add(this.txtName);
            this.Controls.Add(this.txtEmail);
            this.Controls.Add(this.txtContact);
            this.Controls.Add(this.txtBookName);
            this.Controls.Add(this.txtCategory);
            this.Controls.Add(this.btnSave);
            this.Controls.Add(this.btnClear);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
            this.Name = "BorrowInsert";
            this.Text = "BorrowInsert";
            this.Load += new System.EventHandler(this.BorrowInsert_Load);
        }

        #endregion

        public Guna.UI2.WinForms.Guna2TextBox 
            txtStuNo;
        public Guna.UI2.WinForms.Guna2TextBox txtbId;
        public Guna.UI2.WinForms.Guna2TextBox txtName;
        public Guna.UI2.WinForms.Guna2TextBox txtEmail;
        public Guna.UI2.WinForms.Guna2TextBox txtContact;
        public Guna.UI2.WinForms.Guna2TextBox txtBookName;
        public Guna.UI2.WinForms.Guna2TextBox txtCategory;
        private Guna.UI2.WinForms.Guna2GradientButton btnSave;
        private Guna.UI2.WinForms.Guna2GradientButton btnClear;
        private Guna.UI2.WinForms.Guna2CircleButton guna2CircleButton1;
        private Guna.UI2.WinForms.Guna2Panel guna2Panel1;
        private System.Windows.Forms.Label label1;
        private Guna.UI2.WinForms.Guna2MessageDialog guna2MessageDialog1;
    }
}
