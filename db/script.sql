USE [fanuc]
GO
/****** Object:  User [fanuc]    Script Date: 17/03/2017 12:31:40 PM ******/
CREATE USER [fanuc] WITHOUT LOGIN WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  Table [dbo].[fanuc_admin]    Script Date: 17/03/2017 12:31:40 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fanuc_admin](
	[admin_username] [varchar](50) NOT NULL,
	[admin_password] [varchar](50) NOT NULL,
	[admin_email] [varchar](50) NOT NULL,
	[admin_id] [int] IDENTITY(1,1) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[admin_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[fanuc_enquiry]    Script Date: 17/03/2017 12:31:40 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fanuc_enquiry](
	[enquiry_id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[enquiry_details] [text] NOT NULL,
	[created_date] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[enquiry_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
/****** Object:  Table [dbo].[fanuc_product_category]    Script Date: 17/03/2017 12:31:40 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fanuc_product_category](
	[product_category_id] [int] IDENTITY(1,1) NOT NULL,
	[product_category_name] [varchar](100) NOT NULL,
	[product_category_description] [text] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[product_category_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
/****** Object:  Table [dbo].[fanuc_product_registration]    Script Date: 17/03/2017 12:31:40 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fanuc_product_registration](
	[product_registration_id] [int] IDENTITY(1,1) NOT NULL,
	[mtb_maker] [varchar](200) NOT NULL,
	[machine_model] [varchar](100) NOT NULL,
	[machine_serial_number] [varchar](100) NOT NULL,
	[system_model] [varchar](100) NOT NULL,
	[system_serial_number] [varchar](100) NOT NULL,
	[created_date] [datetime] NOT NULL,
	[product_category_id] [int] NOT NULL,
	[install_id] [varchar](100) NOT NULL,
	[user_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[product_registration_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[fanuc_service_request]    Script Date: 17/03/2017 12:31:40 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fanuc_service_request](
	[service_request_id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[service_type] [varchar](100) NOT NULL,
	[product_category_id] [int] NOT NULL,
	[install_id] [varchar](100) NOT NULL,
	[problem_details] [text] NOT NULL,
	[created_date] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[service_request_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
/****** Object:  Table [dbo].[fanuc_user]    Script Date: 17/03/2017 12:31:40 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fanuc_user](
	[user_id] [int] IDENTITY(1,1) NOT NULL,
	[name] [varchar](50) NOT NULL,
	[designation] [varchar](100) NOT NULL,
	[company_name] [varchar](100) NOT NULL,
	[company_address] [varchar](100) NOT NULL,
	[country] [varchar](100) NOT NULL,
	[state] [varchar](100) NOT NULL,
	[city] [varchar](100) NOT NULL,
	[pin_code] [varchar](100) NOT NULL,
	[mobile_number] [varchar](100) NOT NULL,
	[country_code] [varchar](100) NOT NULL,
	[email_address] [varchar](100) NOT NULL,
	[company_tnt_cst_no] [varchar](100) NOT NULL,
	[company_pan] [varchar](100) NOT NULL,
	[user_type] [varchar](100) NOT NULL,
	[user_name] [varchar](100) NOT NULL,
	[password] [varchar](100) NOT NULL,
	[user_status] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
ALTER TABLE [dbo].[fanuc_user] ADD  DEFAULT ((1)) FOR [user_status]
GO
