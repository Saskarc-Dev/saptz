USE [master]
GO
/****** Object:  Database [saptz]    Script Date: 10/25/2019 6:28:53 AM ******/
CREATE DATABASE [saptz]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'saptz', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.MSSQLSERVER\MSSQL\DATA\saptz.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'saptz_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.MSSQLSERVER\MSSQL\DATA\saptz_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
GO
ALTER DATABASE [saptz] SET COMPATIBILITY_LEVEL = 140
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [saptz].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [saptz] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [saptz] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [saptz] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [saptz] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [saptz] SET ARITHABORT OFF 
GO
ALTER DATABASE [saptz] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [saptz] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [saptz] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [saptz] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [saptz] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [saptz] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [saptz] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [saptz] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [saptz] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [saptz] SET  DISABLE_BROKER 
GO
ALTER DATABASE [saptz] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [saptz] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [saptz] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [saptz] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [saptz] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [saptz] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [saptz] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [saptz] SET RECOVERY FULL 
GO
ALTER DATABASE [saptz] SET  MULTI_USER 
GO
ALTER DATABASE [saptz] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [saptz] SET DB_CHAINING OFF 
GO
ALTER DATABASE [saptz] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [saptz] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [saptz] SET DELAYED_DURABILITY = DISABLED 
GO
EXEC sys.sp_db_vardecimal_storage_format N'saptz', N'ON'
GO
ALTER DATABASE [saptz] SET QUERY_STORE = OFF
GO
USE [saptz]
GO
/****** Object:  UserDefinedFunction [dbo].[fn_getdaysoff]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz	
-- Create date: August 27, 2019
-- Description:	Get days off for an employee
-- =============================================
CREATE FUNCTION [dbo].[fn_getdaysoff]
(
	@empid bigint
)
RETURNS varchar(50)
AS
BEGIN
	
	declare @mon as bit, @tue as bit, @wed as bit, @thu as bit, @fri as bit, @sat as bit, @sun as bit;
	declare @daysoff varchar(50);

	select @mon = ro_mon, @tue = ro_tue, @wed = ro_wed, @thu = ro_thu, @fri = ro_fri, @sat = ro_sat, @sun = ro_sun
	from employmentdetails
	where empid = @empid;

	if @mon = 0 set @daysoff = 'Mon';
	if @tue = 0 set @daysoff = case when len(isnull(@daysoff, '')) = 0 then 'Tue' else @daysoff + ', Tue' end;
	if @wed = 0 set @daysoff = case when len(isnull(@daysoff, '')) = 0 then 'Wed' else @daysoff + ', Wed' end; 
	if @thu = 0 set @daysoff = case when len(isnull(@daysoff, '')) = 0 then 'Thu' else @daysoff + ', Thu' end; 
	if @fri = 0 set @daysoff = case when len(isnull(@daysoff, '')) = 0 then 'Fri' else @daysoff + ', Fri' end;
	if @sat = 0 set @daysoff = case when len(isnull(@daysoff, '')) = 0 then 'Sat' else @daysoff + ', Sat' end; 
	if @sun = 0 set @daysoff = case when len(isnull(@daysoff, '')) = 0 then 'Sun' else @daysoff + ', Sun' end; 

	return @daysoff;

END
GO
/****** Object:  Table [dbo].[activity]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[activity](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[wcid] [bigint] NOT NULL,
	[actcode] [varchar](15) NOT NULL,
	[actdesc] [varchar](100) NOT NULL,
	[isactive] [bit] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[wcid] ASC,
	[actcode] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ci_sessions]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ci_sessions](
	[id] [varchar](128) NOT NULL,
	[ip_address] [varchar](45) NOT NULL,
	[timestamp] [int] NOT NULL,
	[data] [nvarchar](max) NULL,
PRIMARY KEY CLUSTERED 
(
	[timestamp] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[customers]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[customers](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[custcode] [varchar](25) NOT NULL,
	[custname] [varchar](150) NOT NULL,
	[addr1] [varchar](150) NOT NULL,
	[addr2] [varchar](150) NULL,
	[city] [varchar](25) NOT NULL,
	[state] [varchar](25) NOT NULL,
	[zipcode] [varchar](10) NOT NULL,
	[country] [varchar](50) NOT NULL,
	[phoneno] [varchar](25) NULL,
	[isactive] [bit] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[department]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[department](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[deptcode] [varchar](25) NULL,
	[deptname] [varchar](150) NOT NULL,
	[deptleadid] [bigint] NOT NULL,
	[isactive] [bit] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[deptworkcenters]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[deptworkcenters](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[deptid] [bigint] NOT NULL,
	[wcid] [bigint] NOT NULL,
	[isactive] [bit] NOT NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
 CONSTRAINT [PK_deptworkcenters] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[employees]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[employees](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[empcode] [varchar](25) NOT NULL,
	[emppwd] [nvarchar](max) NOT NULL,
	[empname] [varchar](150) NOT NULL,
	[empLN] [varchar](50) NOT NULL,
	[empFN] [varchar](50) NOT NULL,
	[empMN] [varchar](50) NULL,
	[addr] [varchar](150) NOT NULL,
	[city] [varchar](50) NOT NULL,
	[state] [varchar](10) NOT NULL,
	[zipcode] [varchar](15) NOT NULL,
	[country] [varchar](50) NOT NULL,
	[phoneno] [varchar](50) NULL,
	[ssno] [varchar](50) NULL,
	[isactive] [bit] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[employmentdetails]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[employmentdetails](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[empid] [bigint] NOT NULL,
	[deptid] [bigint] NOT NULL,
	[shiftid] [bigint] NOT NULL,
	[cb1] [int] NULL,
	[iscb1paid] [bit] NULL,
	[lb] [int] NULL,
	[islbpaid] [bit] NULL,
	[cb2] [int] NULL,
	[iscb2paid] [bit] NULL,
	[hrrate] [float] NOT NULL,
	[ro_mon] [bit] NOT NULL,
	[ro_tue] [bit] NOT NULL,
	[ro_wed] [bit] NOT NULL,
	[ro_thu] [bit] NOT NULL,
	[ro_fri] [bit] NOT NULL,
	[ro_sat] [bit] NOT NULL,
	[ro_sun] [bit] NOT NULL,
	[isactive] [bit] NOT NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[groupmembers]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[groupmembers](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[grpid] [bigint] NOT NULL,
	[empid] [bigint] NOT NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[groups]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[groups](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[grpcode] [varchar](25) NOT NULL,
	[grpname] [varchar](150) NOT NULL,
	[grpleadid] [bigint] NOT NULL,
	[isactive] [bit] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[grpcode] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[joblogs]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[joblogs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[empid] [bigint] NOT NULL,
	[jobdate] [date] NOT NULL,
	[timestart] [datetime] NOT NULL,
	[timeend] [datetime] NULL,
	[orderid] [bigint] NOT NULL,
	[jobid] [bigint] NOT NULL,
	[wcid] [bigint] NOT NULL,
	[actid] [bigint] NOT NULL,
	[locationinfo] [nvarchar](max) NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[orderdetails]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[orderdetails](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[orderid] [bigint] NOT NULL,
	[jobno] [varchar](25) NOT NULL,
	[partno] [varchar](100) NOT NULL,
	[partdesc] [varchar](max) NULL,
	[isactive] [bit] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[orders]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[orders](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[custid] [bigint] NOT NULL,
	[custcode] [varchar](25) NOT NULL,
	[orderno] [varchar](25) NOT NULL,
	[quoteno] [varchar](25) NULL,
	[isactive] [bit] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[shifts]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[shifts](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[shiftcode] [varchar](25) NOT NULL,
	[shiftdesc] [varchar](150) NULL,
	[istimebased] [bit] NULL,
	[timestart] [time](7) NULL,
	[timeend] [time](7) NULL,
	[isworkweekbased] [bit] NULL,
	[workweekquota] [float] NULL,
	[isflexible] [bit] NULL,
	[workdayquota] [float] NULL,
	[isactive] [bit] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[shiftcode] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[timelogs]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[timelogs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[empid] [bigint] NOT NULL,
	[workdate] [date] NULL,
	[timein] [datetime] NULL,
	[ofl] [datetime] NULL,
	[bfl] [datetime] NULL,
	[timeout] [datetime] NULL,
	[locationinfo] [nvarchar](max) NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[timesheetd]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[timesheetd](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[tshid] [bigint] NOT NULL,
	[empid] [bigint] NOT NULL,
	[workdate] [date] NULL,
	[timein] [datetime] NULL,
	[ofl] [datetime] NULL,
	[bfl] [datetime] NULL,
	[timeout] [datetime] NULL,
	[othrs] [float] NULL,
	[uthrs] [float] NULL,
	[tardyhrs] [float] NULL,
	[isonleave] [bit] NULL,
	[isabsent] [bit] NULL,
	[isholiday] [bit] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[timesheeth]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[timesheeth](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[coyear] [int] NULL,
	[comonth] [int] NULL,
	[cofrom] [int] NULL,
	[coto] [int] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[workcenter]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[workcenter](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[wccode] [varchar](15) NOT NULL,
	[wcdesc] [varchar](100) NOT NULL,
	[isactive] [bit] NULL,
	[createdbyid] [bigint] NOT NULL,
	[dtcreated] [datetime] NOT NULL,
	[modifiedbyid] [bigint] NULL,
	[dtmodified] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[wccode] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[activity] ADD  DEFAULT ((1)) FOR [isactive]
GO
ALTER TABLE [dbo].[activity] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[activity] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[activity] ADD  DEFAULT ((0)) FOR [modifiedbyid]
GO
ALTER TABLE [dbo].[ci_sessions] ADD  DEFAULT ((0)) FOR [timestamp]
GO
ALTER TABLE [dbo].[customers] ADD  DEFAULT ((1)) FOR [isactive]
GO
ALTER TABLE [dbo].[customers] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[customers] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[customers] ADD  DEFAULT ((0)) FOR [modifiedbyid]
GO
ALTER TABLE [dbo].[department] ADD  DEFAULT ((1)) FOR [isactive]
GO
ALTER TABLE [dbo].[department] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[department] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[department] ADD  DEFAULT ((0)) FOR [modifiedbyid]
GO
ALTER TABLE [dbo].[deptworkcenters] ADD  DEFAULT ((0)) FOR [deptid]
GO
ALTER TABLE [dbo].[deptworkcenters] ADD  DEFAULT ((0)) FOR [wcid]
GO
ALTER TABLE [dbo].[deptworkcenters] ADD  DEFAULT ((1)) FOR [isactive]
GO
ALTER TABLE [dbo].[deptworkcenters] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[deptworkcenters] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((0)) FOR [cb1]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((0)) FOR [iscb1paid]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((60)) FOR [lb]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((0)) FOR [islbpaid]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((0)) FOR [cb2]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((0)) FOR [iscb2paid]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((1)) FOR [ro_mon]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((1)) FOR [ro_tue]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((1)) FOR [ro_wed]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((1)) FOR [ro_thu]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((1)) FOR [ro_fri]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((1)) FOR [ro_sat]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((1)) FOR [ro_sun]
GO
ALTER TABLE [dbo].[employmentdetails] ADD  DEFAULT ((1)) FOR [isactive]
GO
ALTER TABLE [dbo].[groupmembers] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[groupmembers] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[groupmembers] ADD  DEFAULT ((0)) FOR [modifiedbyid]
GO
ALTER TABLE [dbo].[orderdetails] ADD  DEFAULT ((1)) FOR [isactive]
GO
ALTER TABLE [dbo].[orderdetails] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[orderdetails] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[orderdetails] ADD  DEFAULT ((0)) FOR [modifiedbyid]
GO
ALTER TABLE [dbo].[orders] ADD  DEFAULT ((1)) FOR [isactive]
GO
ALTER TABLE [dbo].[orders] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[orders] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[orders] ADD  DEFAULT ((0)) FOR [modifiedbyid]
GO
ALTER TABLE [dbo].[shifts] ADD  DEFAULT ((1)) FOR [istimebased]
GO
ALTER TABLE [dbo].[shifts] ADD  DEFAULT ((0)) FOR [isworkweekbased]
GO
ALTER TABLE [dbo].[shifts] ADD  DEFAULT ((40)) FOR [workweekquota]
GO
ALTER TABLE [dbo].[shifts] ADD  DEFAULT ((0)) FOR [isflexible]
GO
ALTER TABLE [dbo].[shifts] ADD  DEFAULT ((8)) FOR [workdayquota]
GO
ALTER TABLE [dbo].[shifts] ADD  DEFAULT ((1)) FOR [isactive]
GO
ALTER TABLE [dbo].[timelogs] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[timelogs] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[timelogs] ADD  DEFAULT ((0)) FOR [modifiedbyid]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT ((0)) FOR [tshid]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT ((0)) FOR [empid]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT ((0)) FOR [othrs]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT ((0)) FOR [uthrs]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT ((0)) FOR [tardyhrs]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT ((0)) FOR [isonleave]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT ((0)) FOR [isabsent]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT ((0)) FOR [isholiday]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[timesheetd] ADD  DEFAULT ((0)) FOR [modifiedbyid]
GO
ALTER TABLE [dbo].[timesheeth] ADD  DEFAULT (datepart(year,getdate())) FOR [coyear]
GO
ALTER TABLE [dbo].[timesheeth] ADD  DEFAULT (datepart(month,getdate())) FOR [comonth]
GO
ALTER TABLE [dbo].[timesheeth] ADD  DEFAULT ((1)) FOR [cofrom]
GO
ALTER TABLE [dbo].[timesheeth] ADD  DEFAULT ((31)) FOR [coto]
GO
ALTER TABLE [dbo].[timesheeth] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[timesheeth] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[timesheeth] ADD  DEFAULT ((0)) FOR [modifiedbyid]
GO
ALTER TABLE [dbo].[workcenter] ADD  DEFAULT ((1)) FOR [isactive]
GO
ALTER TABLE [dbo].[workcenter] ADD  DEFAULT ((0)) FOR [createdbyid]
GO
ALTER TABLE [dbo].[workcenter] ADD  DEFAULT (getdate()) FOR [dtcreated]
GO
ALTER TABLE [dbo].[workcenter] ADD  DEFAULT ((0)) FOR [modifiedbyid]
GO
/****** Object:  StoredProcedure [dbo].[sp_fillinlostlogs]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: August 26, 2019
-- Description:	Fill in Lost logs. System will automatically fill up missing logs
--				for example returned from work after weekends and/or long vacation.
-- =============================================
CREATE PROCEDURE [dbo].[sp_fillinlostlogs] 
	@eid bigint, 
	@locip nvarchar(max)
AS
BEGIN
	declare @dtlastlog as date;
	declare @currentlog as date;
	declare @tmpdt as date;

	set @dtlastlog = (select max(workdate) from timelogs where empid = @eid);
	set @currentlog = (select cast(getdate() as date));
	set @tmpdt = dateadd(day, 1, @dtlastlog);

	while(@tmpdt <= @currentlog)
	begin
		insert into timelogs (empid, workdate, timein, ofl, bfl, [timeout], locationinfo, createdbyid, dtcreated)
		values (@eid, @tmpdt, null, null, null, null, @locip, 0, getdate());

		set @tmpdt = DATEADD(day, 1, @tmpdt);
	end

END
GO
/****** Object:  StoredProcedure [dbo].[sp_getactivity]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[sp_getactivity]
	@wcid as bigint
AS
BEGIN
	select id, actcode, actdesc from activity where wcid = @wcid and isactive = 1;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_getdepartments]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: October 2, 2019
-- Description:	Get Departments
-- =============================================
CREATE PROCEDURE [dbo].[sp_getdepartments]
	@listype int,
	@id bigint = 0
AS
BEGIN

	set nocount on;

	-- For drop down
	if @listype = 0
		select id as deptid, deptcode + ' : ' + deptname as dept from department where isactive = 1;
	else 
	
	-- For table display
	if @listype = 1
		select
			d.id as deptid,
			d.deptcode as code,
			d.deptname,
			e.empname as deptlead
		from			department	as d
			left join	employees	as e on d.deptleadid = e.id
		where 
			d.isactive = 1;
	else

	-- For Info loading
	if @listype = 2
		select id, deptcode, deptname, deptleadid from department where id = @id;
	else

	-- Load additional dependencies
	if @listype = 3
		select
			dw.id as wcid,
			wc.wccode + ' : ' + wc.wcdesc as wc
		from			deptworkcenters as dw
			inner join	workcenter		as wc on dw.wcid = wc.id
		where 
				dw.deptid = @id
			and	dw.isactive = 1;


	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_getemployees]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: October 2, 2019
-- Description:	Get Employees
-- =============================================
CREATE PROCEDURE [dbo].[sp_getemployees] 
	@listype int,
	@id bigint = 0
AS
BEGIN

	set nocount on;

	-- For drop down
	if @listype = 0
		select id as empid, empname as empnm from employees where isactive = 1 order by empname asc;
	else 
	
	-- For table display
	if @listype = 1
		select id, empcode, addr, city, state, ssno from employees where isactive = 1;
	else

	-- For Info loading
	if @listype = 2
		select e.id, e.empcode, e.addr, e.city, e.state, e.ssno,
			   ed.deptid, ed.shiftid, ed.cb1, ed.iscb1paid, ed.lb, ed.islbpaid, ed.cb2, ed.iscb2paid, ed.hrrate,
			   ed.ro_mon, ed.ro_tue, ed.ro_wed, ed.ro_thu, ed.ro_fri, ed.ro_sat, ed.ro_sun
		from			employees			as e 
			inner join	employmentdetails	as ed on e.id = ed.empid
		where 
				e.isactive = 1 
			and e.id = @id;
	else

	-- Load additional dependencies
	if @listype = 3
		select 'No dependencies.';


	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_getjoblogs]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[sp_getjoblogs] 
	@empid as bigint, 
	@dtstart as date,
	@dtend as date
AS
BEGIN
	if(@dtstart is null and @dtend is null)
		select	a.jobdate, b.wccode, isnull(c.actcode, 'N/A') as actcode, isnull(d.orderno, 'N/A') as orderno, isnull(e.jobno, 'N/A') as jobno,
				format(a.timestart, N'hh:mm tt') as timestart, format(a.timeend, N'hh:mm tt') as timeend, 
				format((datediff(minute, a.timestart, a.timeend) / 60.00), 'N') as cyclehrs, 
				format(isnull(datediff(minute,(select timeend from joblogs where id = (a.id - 1)), a.timestart) / 60.00, 0), 'N') as uat
		from			joblogs		as a
			inner join	workcenter	as b on a.wcid = b.id
			left  join	activity	as c on a.actid = c.id
			left  join	orders		as d on a.orderid = d.id
			left  join	orderdetails as e on a.jobid = e.id
		where	a.empid = @empid
			and a.jobdate = cast(getdate() as date);

	else

		select	a.jobdate, b.wccode, isnull(c.actcode, 'N/A') as actcode, isnull(d.orderno, 'N/A') as orderno, isnull(e.jobno, 'N/A') as jobno,
				format(a.timestart, N'hh:mm tt') as timestart, format(a.timeend, N'hh:mm tt') as timeend, 
				format((datediff(minute, a.timestart, a.timeend) / 60.00), 'N') as cyclehrs, 
				format(isnull(datediff(minute,(select timeend from joblogs where id = (a.id - 1)), a.timestart) / 60.00, 0), 'N') as uat
		from			joblogs		as a
			inner join	workcenter	as b on a.wcid = b.id
			left  join	activity	as c on a.actid = c.id
			left  join	orders		as d on a.orderid = d.id
			left  join	orderdetails as e on a.jobid = e.id
		where (a.jobdate between @dtstart and @dtend)
			and a.empid = @empid;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_getjobs]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel Dela Cruz
-- Create date: August 27, 2019
-- Description:	Get all jobs linked to a given order id
-- =============================================
CREATE PROCEDURE [dbo].[sp_getjobs] 
	@orderid as bigint
AS
BEGIN
	select id, orderid, jobno, partno from orderdetails where orderid = @orderid and isactive = 1;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_getlogstatus]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: August 27, 2019
-- Description:	Get clocking status
-- =============================================
CREATE PROCEDURE [dbo].[sp_getlogstatus]
	@empid bigint
AS
BEGIN
	
	declare @lstworkdate as date;
	declare @nxtworkdate as date;
	declare @shiftflag as bit;
	declare @shiftdt as datetime;

	set nocount on;

	set @lstworkdate = (select top 1 cast(isnull(workdate, getdate()) as date) as workdate from timelogs where empid = @empid and timein is not null and timeout is null order by workdate desc);
	set @nxtworkdate = cast(getdate() as date);
	set @shiftflag	 = (select isnull(case when timeout is null then 1 else 0 end, 0) from timelogs where empid = @empid and workdate = @lstworkdate)
	set @shiftdt	 = (select	dateadd(hour, -6, cast(concat(convert(varchar, @nxtworkdate, 23), ' ', convert(varchar, sh.timestart, 8)) as datetime))
					   from			employmentdetails	as ed
						  inner join	shifts			as sh on ed.shiftid = sh.id
					   where ed.empid = @empid);

	

	if getdate() >= cast(@shiftdt as datetime)
		begin
			if (select count(id) from timelogs where empid = @empid and workdate = cast(@shiftdt as date)) > 0
				begin
					select top 1
						id, @lstworkdate as ld, @nxtworkdate as nd, @shiftflag sf, @shiftdt as sdt,
						case when timein is null then 1 else 0 end as timein,
						case when ofl is null then 1 else 0 end as ofl,
						case when bfl is null then 1 else 0 end as bfl,
						case when timeout is null then 1 else 0 end as timeout
					from timelogs
					where	empid = @empid
					    and workdate = cast(@shiftdt as date)
					order by workdate asc;
				end
			else
				begin
					select	@empid as id, @lstworkdate as ld, @nxtworkdate as nd,  @shiftflag sf, @shiftdt as sdt,
					1 as timein, 
					1 as ofl, 
					1 as bfl, 
					1 as timeout;
				end
		end
	else
		begin
			select	@empid as id, @lstworkdate as ld, @nxtworkdate as nd,  @shiftflag sf, @shiftdt as sdt,
					0 as timein, 
					0 as ofl, 
					0 as bfl, 
					0 as timeout;
		end

	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_getmembers]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: August 30, 2019
-- Description:	Get all group members if a lead logs into the system.
-- =============================================
CREATE PROCEDURE [dbo].[sp_getmembers] 
	@leadid as bigint
AS
BEGIN
	
	set nocount on;

	select	
		ee.id as empid, 
		gp.grpcode, 
		gp.grpname, 
		ee.empname, 
		case 
			when (jl.timestart is null and jl.timeend is null) then 0 
			else 1 
		end as intask,
	    case when tl.timein is null then 0 else 1 end as inofc 
	from			groups			as gp
		inner join	groupmembers	as gm on gp.id = gm.grpid
		inner join	employees		as ee on gm.empid = ee.id
		left  join	joblogs			as jl on gm.empid = jl.empid
											and jl.jobdate = cast(getdate() as date)
											and jl.timeend is null
		left  join	timelogs		as tl on gm.empid = tl.empid	
											and tl.workdate = cast(getdate() as date)
	where 
			gp.grpleadid = @leadid

	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_getorders]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[sp_getorders]
	
AS
BEGIN
	select a.id, a.orderno, b.custcode, b.custname
    from			orders		as a
        left join	customers	as b on a.custid = b.id
    where a.isactive = 1;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_gettimesheet]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[sp_gettimesheet]
	@empid as bigint,
	@dtstart as date,
	@dtend as date
AS
BEGIN

	set nocount on;

	declare @upbreak as float;

	set @upbreak = (select lb from employmentdetails where empid = @empid);

	if(@dtstart is null and @dtend is null)
		begin
			select	a.empid, d.shiftcode, a.workdate, format(a.timein, N'hh:mm tt') as timein, format(a.ofl, N'hh:mm tt') as ofl, format(a.bfl, N'hh:mm tt') as bfl, format(a.[timeout], N'hh:mm tt') as [timeout],
					case 
						when datediff(minute, cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timestart, 8)) as datetime), a.timein) <= 0
							then 0 
							else cast((datediff(minute, cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timestart, 8)) as datetime), a.timein) / 60.00) as decimal(10, 2))
					end as tardy,
					case 
						when datediff(minute, a.[timeout], cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timeend, 8)) as datetime)) <= 0
							then 0 
							else cast(((datediff(minute, a.[timeout], cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timeend, 8)) as datetime)) - @upbreak) / 60.00) as decimal(10, 2))
					end as ut,
					case 
						when datediff(minute, cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timeend, 8)) as datetime), a.[timeout]) <= 0
							then 0 
							else cast((datediff(minute, cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timeend, 8)) as datetime), a.[timeout]) / 60.00) as decimal(10, 2))
					end as ot,
					case 
						when ((datediff(minute, (case when cast(a.timein as time) < d.timestart then cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timestart, 8)) as datetime) else a.timein end), a.[timeout]) - @upbreak) / 60.00) <= 0
							then 0
							else cast(((datediff(minute, (case when cast(a.timein as time) < d.timestart then cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timestart, 8)) as datetime) else a.timein end), a.[timeout]) - @upbreak) / 60.00) as decimal(10, 2))
					end as wrkdHours
			from			timelogs			as a 
				inner join	employees			as b on a.empid = b.id
				inner join	employmentdetails	as c on b.id = c.empid
				left  join  shifts				as d on c.shiftid = d.id
			where	a.empid = @empid
				and (a.workdate = cast(getdate() as date) or a.workdate = cast(dateadd(day, -1, getdate()) as date))
				and a.timein is not null;
		end

	else
		begin
			select	a.empid, d.shiftcode, a.workdate, format(a.timein, N'hh:mm tt') as timein, format(a.ofl, N'hh:mm tt') as ofl, format(a.bfl, N'hh:mm tt') as bfl, format(a.[timeout], N'hh:mm tt') as [timeout],
					case 
						when datediff(minute, cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timestart, 8)) as datetime), a.timein) <= 0
							then 0 
							else cast((datediff(minute, cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timestart, 8)) as datetime), a.timein) / 60.00) as decimal(10, 2))
					end as tardy,
					case 
						when datediff(minute, a.[timeout], cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timeend, 8)) as datetime)) <= 0
							then 0 
							else cast(((datediff(minute, a.[timeout], cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timeend, 8)) as datetime)) - @upbreak) / 60.00) as decimal(10, 2))
					end as ut,
					case 
						when datediff(minute, cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timeend, 8)) as datetime), a.[timeout]) <= 0
							then 0 
							else cast((datediff(minute, cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timeend, 8)) as datetime), a.[timeout]) / 60.00) as decimal(10, 2))
					end as ot,
					case 
						when ((datediff(minute, (case when cast(a.timein as time) < d.timestart then cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timestart, 8)) as datetime) else a.timein end), a.[timeout]) - @upbreak) / 60.00) <= 0
							then 0
							else cast(((datediff(minute, (case when cast(a.timein as time) < d.timestart then cast(concat(convert(varchar, a.workdate, 23), ' ', convert(varchar, d.timestart, 8)) as datetime) else a.timein end), a.[timeout]) - @upbreak) / 60.00) as decimal(10, 2))
					end as wrkdHours
			from			timelogs			as a 
				inner join	employees			as b on a.empid = b.id
				inner join	employmentdetails	as c on b.id = c.empid
				left  join  shifts				as d on c.shiftid = d.id
			where	(a.workdate between @dtstart and @dtend)
				and a.empid = @empid
				and a.timein is not null;
		end

	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_getworkcenters]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: October 4, 2019
-- Description:	Get Workcenters
-- =============================================
CREATE PROCEDURE [dbo].[sp_getworkcenters]
	@listype as int,
	@id as bigint = 0,
	@deptid as bigint = 0
AS
BEGIN
	--select a.deptid, a.wcid, b.wccode, b.wcdesc 
 --   from			deptworkcenters as a
 --       inner join	workcenter		as b on a.wcid = b.id
 --   where a.deptid = @deptid;

 
	set nocount on;

	-- For drop down
	if @listype = 0
		select id as wcid, wccode + ' : ' + wcdesc as wc from workcenter where isactive = 1;
	else 
	
	-- For table display
	if @listype = 1
		select id, wccode, wcdesc from workcenter where isactive = 1;
	else

	-- For Info loading
	if @listype = 2
		select id, wccode, wcdesc from workcenter where isactive = 1 and id = @id;
	else

	-- Load additional dependencies
	if @listype = 3
		-- Load to dropdown in which WC is not registered yet to the department.
		select id as wcid, wccode + ' : ' + wcdesc as wc from workcenter where id not in (select wcid from deptworkcenters where deptid = @deptid and isactive = 1) and isactive = 1;


	set nocount off;



END
GO
/****** Object:  StoredProcedure [dbo].[sp_getworkgroups]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: October 5, 2019
-- Description:	Get Workgroups
-- =============================================
CREATE PROCEDURE [dbo].[sp_getworkgroups]
	@listype as int,
	@id as bigint  = 0,
	@empid as bigint = 0

AS
BEGIN

	set nocount on;

	-- For drop down
	if @listype = 0
		select id as wgid, grpcode + ' : ' + grpname as grp from groups where isactive = 1 and grpleadid = @empid;
	else 
	
	-- For table display
	if @listype = 1
		select
			g.id as grpid,
			g.grpcode as code,
			g.grpname as nm,
			e.empname as deptlead
		from			groups	as g
			left join	employees	as e on g.grpleadid = e.id
		where 
				g.isactive = 1
			and g.grpleadid = @empid;
	else

	-- For Info loading
	if @listype = 2
		select id, grpcode, grpname, grpleadid from groups where id = @id;
	else

	-- Load additional dependencies
	if @listype = 3
		-- Currently registered group members
		select
			gm.id as memid,
			e.id as empid,
			e.empname as empnm
		from			groups			as g
			inner join	groupmembers	as gm	on g.id = gm.grpid
			inner join	employees		as e	on gm.empid = e.id
		where 
				g.isactive = 1
			and g.id = @id
			and g.grpleadid = @empid;
	else

	if @listype = 4
		-- Available employees to add to workgroup
		select 
			id as empid, empname as empnm 
		from employees 
		where 
				id not in ( select
							gm.empid
						from			groups			as g
							inner join	groupmembers	as gm	on g.id = gm.grpid
						where 
								g.isactive = 1
							and g.grpleadid = @empid )
			and id != @empid;

	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_getworkshifts]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: October 10, 2019
-- Description:	Get workshifts
-- =============================================
CREATE PROCEDURE [dbo].[sp_getworkshifts]
	@listype as int,
	@shiftid as bigint

AS
BEGIN

	set nocount on;

	-- For drop down
	if @listype = 0
		select id as shid, shiftcode + ' : ' + shiftdesc as shiftnm from shifts where id = @shiftid and isactive = 1;
	else 
	
	-- For table display
	if @listype = 1
		select
			id as shid,
			shiftcode as sc,
			shiftdesc as sd,
			convert(varchar, timestart, 0) as ts,
			convert(varchar, timeend, 0) as te,
			isworkweekbased as isweek,
			workweekquota as weekq,
			isflexible as isflex,
			workdayquota flexq,
			isactive as ia
		from shifts
		where
				isactive = 1;
	else

	-- For Info loading
	if @listype = 2
		select
			id as shid,
			shiftcode as sc,
			shiftdesc as sd,
			istimebased as istime,
			timestart as ts,
			timeend as te,
			isworkweekbased as isweek,
			workweekquota as weekq,
			isflexible as isflex,
			workdayquota flexq,
			isactive as ia
		from shifts
		where
				isactive = 1
			and id = @shiftid;
	else

	-- Load additional dependencies

	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_logjobsheet]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[sp_logjobsheet]
	@jobtyp as varchar,
	@empid as bigint,
	@ordid as bigint,
	@jobid as bigint,
	@wrkid as bigint,
	@actid as bigint,
	@locinfo as nvarchar(max),
	@cid as bigint
AS
BEGIN

	declare @workdate as date;
	declare @jobdate as date;
	declare @hasjob as int;
	declare @flag as bit;
	declare @msg as varchar;

	set nocount on;

	set @workdate = (select workdate from timelogs where empid = @empid and timein is not null and [timeout] is null);
	set @jobdate = (case when @workdate is null then cast(getdate() as date) else @workdate end);
	set @hasjob = (select count(id) from joblogs where empid = @empid and timeend is null);

	if @jobtyp = 'job-in'
		begin
			insert into joblogs (empid, jobdate, timestart, orderid, jobid, wcid, actid, locationinfo, createdbyid, dtcreated)
			values (@empid, @jobdate, getdate(), @ordid, @jobid, @wrkid, @actid, @locinfo, @cid, getdate());
			
			set @flag = 1;
			set @msg = 'Job already clocked in. Please don''t forget to clock out once done.';
		end
	else
		begin
			update joblogs set timeend = getdate() where empid = @empid and timeend is null;

			set @flag = 1;
			set @msg = 'Job already clocked out. You can now start a new one.';
		end

	select @flag as flag, @msg as message;

	set nocount off;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_logtimesheet]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: August 27, 2019
-- Description:	Timesheet logging
-- =============================================
CREATE PROCEDURE [dbo].[sp_logtimesheet] 
	@empid bigint,
	@locinfo nvarchar(max), 
	@logtype varchar(25)
AS
BEGIN
	
	declare @curworkday as date;
	declare @nxtworkday as date;
	declare @daysoff as varchar(25);
	declare @retval as nvarchar(max);
	declare @flag as bit;
	declare @msg as varchar(250);
	declare @shiftdt as datetime;

	set @daysoff = (select dbo.fn_getdaysoff(@empid));
	
	set @curworkday = (select max(workdate) from timelogs where empid = @empid);
	set @nxtworkday = cast(getdate() as date);
	set @shiftdt	= (select	dateadd(hour, -6, cast(concat(convert(varchar, @nxtworkday, 23), ' ', convert(varchar,sh.timestart, 8)) as datetime))
					   from			employmentdetails	as ed
						  inner join	shifts			as sh on ed.shiftid = sh.id
					   where ed.empid = @empid); 

	SET NOCOUNT ON;

	--select getdate() as cdate, @shiftdt as shiftdt, @curworkday as lastworkdate, @nxtworkday as nextworkdate, @logtype as lt;

	if (@logtype = 'timein' and getdate() >= cast(@shiftdt as datetime)) 
		begin
			if not exists (select workdate from timelogs where empid = @empid and workdate = isnull(@curworkday, cast(getdate() as date)))
				begin
					insert into timelogs (empid, workdate, timein, locationinfo, createdbyid, dtcreated)
					values (@empid, isnull(@curworkday, cast(getdate() as date)), getdate(), @locinfo, @empid, getdate());
					set @flag = 1;
					set @msg = 'You have successfully clocked in.';

				end
			else
				begin
					update timelogs 
					set timein = getdate(), locationinfo = @locinfo, modifiedbyid = @empid, dtmodified = getdate()
					where empid = @empid and timein is null;

					set @flag = 1;
					set @msg = 'You have successfully clocked in.';

				end
		end

	else if @logtype = 'breakout'
		begin
			update timelogs set ofl = getdate(), modifiedbyid = @empid, dtmodified = getdate() where empid = @empid and ofl is null and timein is not null;
			select cast(1 as bit) as flag, 'You have successfully clocked out (break).' as message;

			set @flag = 1;
			set @msg = 'You have successfully clocked out (break).';

		end

	else if @logtype = 'breakin'
		begin
			update timelogs set bfl = getdate(), modifiedbyid = @empid, dtmodified = getdate() where empid = @empid and bfl is null and timein is not null;
			select cast(1 as bit) as flag, 'You have successfully clocked in (break).' as message;

		end

	else if @logtype = 'timeout'
		begin
			update timelogs set timeout = getdate(), modifiedbyid = @empid, dtmodified = getdate() where empid = @empid and timeout is null and timein is not null;

			set @flag = 1;
			set @msg = 'You have successfully clocked out.';

			if(substring(datename(weekday, @nxtworkday), 1, 3) not in (@daysoff)) insert into timelogs (empid, workdate) values (@empid, @nxtworkday);
		end

	else
		begin
			set @flag = 0;
			set @msg = 'Error clocking in/out. Please contact your system administrator. [Timesheet error]';
		end

	select @flag as flag, @msg as message;

	SET NOCOUNT OFF;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_tranactivity]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: September 27, 2019
-- Description:	Transaction script for Activty
-- =============================================
CREATE PROCEDURE [dbo].[sp_tranactivity] 
	@id bigint,
	@wcid bigint,
	@actcode varchar(15),
	@actdesc varchar(100),
	@isactive bit,
	@cid bigint
AS
BEGIN
	
	declare @name varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(	
		id bigint not null,
		wcid bigint not null, 
		actcode varchar(15) collate SQL_Latin1_General_CP1_CI_AS not null, 
		actdesc varchar(100) collate SQL_Latin1_General_CP1_CI_AS not null, 
		isactive bit null, 
		primary key(id, wcid, actcode)
	);

	-- set intial value to variable when update is triggered
	set @name = (select deptname from department where id = @id);

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, wcid, actcode, actdesc, isactive)
		select id, wcid, actcode, actdesc, isactive from activity where id not in (@id) 
		union all
		select @id, @wcid, @actcode, @actdesc, @isactive; 
	else
		insert into #tmp (id, wcid, actcode, actdesc, isactive)
		select id, wcid, actcode, actdesc, isactive from activity where id not in (@id);

	-- merge process
	merge activity as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (wcid, actcode, actdesc, isactive, createdbyid, dtcreated)
		values (s.wcid, s.actcode, s.actdesc, 1, @cid, getdate())

	when matched and (t.wcid != s.wcid or t.actcode != s.actcode or t.actdesc != s.actdesc) then
		update
		set t.wcid = s.wcid ,t.actcode = s.actcode, t.actdesc = s.actdesc, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @id = 0
			select 1 as flag, @name + ' has been addedd successfully.' as msg;
		else if @isactive = 1 and @id > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, @name + ' has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @id = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @id > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_trancustomer]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: September 28, 2019
-- Description:	Transaction script for customers
-- =============================================
CREATE PROCEDURE [dbo].[sp_trancustomer]
	@id bigint,
	@custcode varchar(25),
	@custname varchar(150),
	@addr1 varchar(150),
	@addr2 varchar(150),
	@city varchar(25),
	@state varchar(25),
	@zipcode varchar(10),
	@country varchar(50),
	@phoneno varchar(25),
	@isactive bit,
	@cid bigint
AS
BEGIN

	declare @name varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(	
		id bigint not null,
		custcode varchar(25) collate SQL_Latin1_General_CP1_CI_AS not null, 
		custname varchar(150) collate SQL_Latin1_General_CP1_CI_AS not null, 
		addr1 varchar(150) collate SQL_Latin1_General_CP1_CI_AS not null,
		addr2 varchar(150) collate SQL_Latin1_General_CP1_CI_AS not null,
		city varchar(25) collate SQL_Latin1_General_CP1_CI_AS not null, 
		state varchar(25) collate SQL_Latin1_General_CP1_CI_AS not null,
		zipcode varchar(10) collate SQL_Latin1_General_CP1_CI_AS not null,
		country varchar(50) collate SQL_Latin1_General_CP1_CI_AS not null,
		phoneno varchar(25) collate SQL_Latin1_General_CP1_CI_AS not null,
		isactive bit null, 
		primary key(id)
	);

	-- set intial value to variable when update is triggered
	set @name = (select custname from customers where id = @id);

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, custcode, custname, addr1, addr2, city, state, zipcode, country, phoneno, isactive)
		select id, custcode, custname, addr1, addr2, city, state, zipcode, country, phoneno, isactive from customers where id not in (@id) 
		union all
		select @id, @custcode, @custname, @addr1, @addr2, @city, @state, @zipcode, @country, @phoneno, @isactive; 
	else
		insert into #tmp (id, custcode, custname, addr1, addr2, city, state, zipcode, country, phoneno, isactive)
		select id, custcode, custname, addr1, addr2, city, state, zipcode, country, phoneno, isactive from customers where id not in (@id); 

	-- merge process
	merge customers as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (custcode, custname, addr1, addr2, city, state, zipcode, country, phoneno, isactive, createdbyid, dtcreated)
		values (s.custcode, s.custname, s.addr1, s.addr2, s.city, s.state, s.zipcode, s.country, s.phoneno, 1, @cid, getdate())

	when matched and (t.custcode != s.custcode or t.custname != s.custname or t.addr1 != s.addr1 or t.addr2 != s.addr2 or t.city != s.city or 
					  t.state != s.state or t.zipcode != s.zipcode or t.country != s.country or t.phoneno != s.phoneno) then
		update
		set t.custcode = s.custcode, t.custname = s.custname, t.addr1 = s.addr1, t.addr2 = s.addr2, t.city = s.city, 
			t.state = s.state, t.zipcode = s.zipcode, t.country = s.country, t.phoneno = s.phoneno, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @id = 0
			select 1 as flag, @name + ' has been addedd successfully.' as msg;
		else if @isactive = 1 and @id > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, @name + ' has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @id = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @id > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_trandepartment]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: September 26, 2019
-- Description:	Transaction script for Department table
-- =============================================
CREATE PROCEDURE [dbo].[sp_trandepartment] 
	@deptid bigint,
	@deptcode varchar(25),
	@deptname varchar(150),
	@deptleadid bigint,
	@isactive bit,
	@cid bigint
AS
BEGIN
	
	declare @dn varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(	
		id bigint not null, 
		deptcode varchar(25) collate SQL_Latin1_General_CP1_CI_AS null, 
		deptname varchar(150) collate SQL_Latin1_General_CP1_CI_AS not null, 
		deptleadid bigint not null, 
		isactive bit null, 
		primary key(id)
	);

	-- set intial value to variable when update is triggered
	set @dn = (select deptname from department where id = @deptid);

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, deptcode, deptname, deptleadid, isactive)
		select id, deptcode, deptname, deptleadid, isactive from department where id not in (@deptid) 
		union all
		select @deptid as id, @deptcode as deptcode, @deptname as deptname, @deptleadid as deptleadid, @isactive as isactive;
	else
		insert into #tmp (id, deptcode, deptname, deptleadid, isactive)
		select id, deptcode, deptname, deptleadid, isactive from department where id not in (@deptid);

	-- merge process
	merge department as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (deptcode, deptname, deptleadid, isactive, createdbyid, dtcreated)
		values (s.deptcode, s.deptname, s.deptleadid, 1, @cid, getdate())

	when matched and (t.deptcode != s.deptcode or t.deptname != s.deptname or t.deptleadid != s.deptleadid) then
		update
		set t.deptcode = s.deptcode, t.deptname = s.deptname, t.deptleadid = s.deptleadid, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @deptid = 0
			select 1 as flag, @deptname + ' has been addedd successfully.' as msg;
		else if @isactive = 1 and @deptid > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, @dn + ' has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @deptid = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @deptid > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_trandeptworkcenter]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: September 28, 2019
-- Description:	Transaction script for Deptworkcenters
-- =============================================
CREATE PROCEDURE [dbo].[sp_trandeptworkcenter]
	@id bigint,
	@deptid bigint,
	@wcid bigint,
	@isactive bit,
	@cid bigint

AS
BEGIN

	declare @name varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(	
		id bigint not null,
		deptid bigint not null,
		wcid bigint not null,
		isactive bit null, 
		primary key(id)
	);

	-- set intial value to variable when update is triggered
	set @name = (select wcdesc from workcenter where id = @wcid);

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, deptid, wcid, isactive)
		select id, deptid, wcid, isactive from deptworkcenters where id != @id 
		union all
		select @id, @deptid, @wcid, @isactive; 
	else
		insert into #tmp (id, deptid, wcid, isactive)
		select id, deptid, wcid, isactive from deptworkcenters where id != @id; 

	-- merge process
	merge deptworkcenters as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (deptid, wcid, isactive, createdbyid, dtcreated)
		values (s.deptid, s.wcid, 1, @cid, getdate())

	when matched and (t.deptid != s.deptid or t.wcid != s.wcid) then
		update
		set t.deptid = s.deptid, t.wcid = s.wcid, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @id = 0
			select 1 as flag, @name + ' has been addedd successfully.' as msg;
		else if @isactive = 1 and @id > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, 'Workcenter has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @id = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @id > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_tranemployee]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: September 29, 2019
-- Description:	Transaction script for Employee
-- =============================================
CREATE PROCEDURE [dbo].[sp_tranemployee] 
	@id bigint,
	@empcode varchar(25),
	@emppwd nvarchar(max),
	@empname varchar(150),
	@empln varchar(50),
	@empfn varchar(50),
	@empmn varchar(50),
	@addr varchar(150),
	@city varchar(50),
	@state varchar(10),
	@zipcode varchar(15),
	@country varchar(50),
	@phoneno varchar(50),
	@ssno varchar(50),
	@isactive bit,
	@cid bigint
AS
BEGIN

	declare @name varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(
		id bigint,
		empcode varchar(25) collate SQL_Latin1_General_CP1_CI_AS not null,
		emppwd nvarchar(max) collate SQL_Latin1_General_CP1_CI_AS not null,
		empname varchar(150) collate SQL_Latin1_General_CP1_CI_AS not null,
		empln varchar(50) collate SQL_Latin1_General_CP1_CI_AS not null,
		empfn varchar(50) collate SQL_Latin1_General_CP1_CI_AS not null,
		empmn varchar(50) collate SQL_Latin1_General_CP1_CI_AS not null,
		addr varchar(150) collate SQL_Latin1_General_CP1_CI_AS not null,
		city varchar(50) collate SQL_Latin1_General_CP1_CI_AS not null,
		state varchar(10) collate SQL_Latin1_General_CP1_CI_AS not null,
		zipcode varchar(15) collate SQL_Latin1_General_CP1_CI_AS not null,
		country varchar(50) collate SQL_Latin1_General_CP1_CI_AS not null,
		phoneno varchar(50) collate SQL_Latin1_General_CP1_CI_AS not null,
		ssno varchar(50) collate SQL_Latin1_General_CP1_CI_AS not null,
		isactive bit,
		primary key(id)
	);

	-- set intial value to variable when update is triggered
	set @name = (select empname from employees where id = @id);

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, empcode, emppwd, empname, empln, empfn, empmn, addr, city, state, zipcode, country, phoneno, isactive)
		select id, empcode, emppwd, empname, empln, empfn, empmn, addr, city, state, zipcode, country, phoneno, isactive from employees where id != @id 
		union all
		select @id, @empcode, @emppwd, @empname, @empln, @empfn, @empmn, @addr, @city, @state, @zipcode, @country, @phoneno, @isactive; 
	else
		insert into #tmp (id, empcode, emppwd, empname, empln, empfn, empmn, addr, city, state, zipcode, country, phoneno, isactive)
		select id, empcode, emppwd, empname, empln, empfn, empmn, addr, city, state, zipcode, country, phoneno, isactive from employees where id != @id;
		 
	-- merge process
	merge employees as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (empcode, emppwd, empname, empln, empfn, empmn, addr, city, state, zipcode, country, phoneno, isactive, createdbyid, dtcreated)
		values (s.empcode, s.emppwd, s.empname, s.empln, s.empfn, s.empmn, s.addr, s.city, s.state, s.zipcode, s.country, s.phoneno, 1, @cid, getdate())

	when matched and (t.empcode != s.empcode or t.emppwd != s.emppwd or t.empln != s.empln or t.empfn != s.empfn or t.empmn != s.empmn or t.addr != s.addr or t.city != s.city or 
					  t.state != s.state or t.zipcode != s.zipcode or t.country != s.country or t.phoneno != s.phoneno) then
		update
		set t.empcode = s.empcode, t.emppwd = s.emppwd, t.empln = s.empln, t.empfn = s.empfn, t.empmn = s.empmn, t.addr = s.addr, t.city = s.city, 
			t.state = s.state, t.zipcode = s.zipcode, t.country = s.country, t.phoneno = s.phoneno, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @id = 0
			select 1 as flag, @name + ' has been addedd successfully.' as msg;
		else if @isactive = 1 and @id > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, @name + ' has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @id = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @id > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_tranemploymentdetails]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: September 30, 2019
-- Description:	Transaction script for Employee employment details
-- =============================================
CREATE PROCEDURE [dbo].[sp_tranemploymentdetails] 
	@id bigint,
	@empid bigint,
	@deptid bigint,
	@shiftid bigint,
	@cb1 int,
	@iscb1paid bit,
	@lb int,
	@islbpaid bit,
	@cb2 int,
	@iscb2paid bit,
	@hrrate float,
	@ro_mon bit,
	@ro_tue bit,
	@ro_wed bit,
	@ro_thu bit,
	@ro_fri bit,
	@ro_sat bit,
	@ro_sun bit,
	@isactive bit,
	@cid bigint

AS
BEGIN

	declare @name varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(
		id bigint,
		empid bigint not null,
		deptid bigint,
		shiftid bigint,
		cb1 int,
		iscb1paid bit,
		lb int,
		islbpaid bit,
		cb2 int,
		iscb2paid bit,
		hrrate float,
		ro_mon bit,
		ro_tue bit,
		ro_wed bit,
		ro_thu bit,
		ro_fri bit,
		ro_sat bit,
		ro_sun bit,
		isactive bit,
		primary key(id)
	);

	-- set intial value to variable when update is triggered
	set @name = (select empname from employees where id = @empid);

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, empid, deptid, shiftid, cb1, iscb1paid, lb, islbpaid, cb2, iscb2paid, hrrate, ro_mon, ro_tue, ro_wed, ro_thu, ro_fri, ro_sat, ro_sun, isactive)
		select id, empid, deptid, shiftid, cb1, iscb1paid, lb, islbpaid, cb2, iscb2paid, hrrate, ro_mon, ro_tue, ro_wed, ro_thu, ro_fri, ro_sat, ro_sun, isactive from employmentdetails where empid != @empid 
		union all
		select @id, @empid, @deptid, @shiftid, @cb1, @iscb1paid, @lb, @islbpaid, @cb2, @iscb2paid, @hrrate, @ro_mon, @ro_tue, @ro_wed, @ro_thu, @ro_fri, @ro_sat, @ro_sun, @isactive; 
	else
		insert into #tmp (id, empid, deptid, shiftid, cb1, iscb1paid, lb, islbpaid, cb2, iscb2paid, hrrate, ro_mon, ro_tue, ro_wed, ro_thu, ro_fri, ro_sat, ro_sun, isactive)
		select id, empid, deptid, shiftid, cb1, iscb1paid, lb, islbpaid, cb2, iscb2paid, hrrate, ro_mon, ro_tue, ro_wed, ro_thu, ro_fri, ro_sat, ro_sun, isactive from employmentdetails where empid != @empid 		 

	-- merge process
	merge employmentdetails as t
	using #tmp as s
	on (t.id = s.id and t.empid = s.empid)
	when not matched by target then 
		insert (empid, deptid, shiftid, cb1, iscb1paid, lb, islbpaid, cb2, iscb2paid, hrrate, ro_mon, ro_tue, ro_wed, ro_thu, ro_fri, ro_sat, ro_sun, isactive, createdbyid, dtcreated)
		values (s.empid, s.deptid, s.shiftid, s.cb1, s.iscb1paid, s.lb, s.islbpaid, s.cb2, s.iscb2paid, s.hrrate, s.ro_mon, s.ro_tue, s.ro_wed, s.ro_thu, s.ro_fri, s.ro_sat, s.ro_sun, 1, @cid, getdate())

	when matched and (t.deptid != s.deptid or t.shiftid != s.shiftid or t.cb1 != s.cb1 or t.iscb1paid != s.iscb1paid or t.lb != s.lb or t.islbpaid != s.islbpaid or t.cb2 != s.cb2 or t.iscb2paid != s.iscb2paid or t.hrrate != s.hrrate or 
					  t.ro_mon != s.ro_mon or t.ro_tue != s.ro_tue or t.ro_wed != s.ro_wed or t.ro_thu != s.ro_thu or t.ro_fri != s.ro_fri or t.ro_sat != s.ro_sat or t.ro_sun != s.ro_sun) then
		update
		set t.deptid = s.deptid, t.shiftid = s.shiftid, t.cb1 = s.cb1, t.iscb1paid = s.iscb1paid, t.lb = s.lb, t.islbpaid = s.islbpaid, t.cb2 = s.cb2, t.iscb2paid = s.iscb2paid, t.hrrate = s.hrrate, 
			t.ro_mon = s.ro_mon, t.ro_tue = s.ro_tue, t.ro_wed = s.ro_wed, t.ro_thu = s.ro_thu, t.ro_fri = s.ro_fri, t.ro_sat = s.ro_sat, t.ro_sun = s.ro_sun, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @id = 0
			select 1 as flag, @name + ' has been addedd successfully.' as msg;
		else if @isactive = 1 and @id > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, @name + ' has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @id = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @id > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_trangroupmembers]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: October 1, 2019
-- Description:	Transaction script for Group Members
-- =============================================
CREATE PROCEDURE [dbo].[sp_trangroupmembers] 
	@id bigint,
	@grpid bigint,
	@empid bigint,
	@isactive bit,
	@cid bigint
AS
BEGIN
	
	declare @name varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(	
		id bigint not null,
		grpid bigint not null,
		empid bigint not null,
		primary key(id)
	);

	-- set intial value to variable when update is triggered
	set @name = (select empname from employees where id = @empid);

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, grpid, empid)
		select id, grpid, empid  from groupmembers where id != @id 
		union all
		select @id, @grpid, @empid; 
	else
		insert into #tmp (id, grpid, empid)
		select id, grpid, empid  from groupmembers where id != @id 

	-- merge process
	merge groupmembers as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (grpid, empid, createdbyid, dtcreated)
		values (s.grpid, s.empid, @cid, getdate())

	when matched and (t.grpid != s.grpid or t.empid != s.empid) then
		update
		set t.grpid = s.grpid, t.empid = s.empid, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		delete;

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @id = 0
			select 1 as flag, 'A member has been addedd successfully.' as msg;
		else if @isactive = 1 and @id > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, 'A member has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @id = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @id > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_trangroups]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: October 1, 2019
-- Description:	Transaction script for groups
-- =============================================
CREATE PROCEDURE [dbo].[sp_trangroups]
	@id bigint,
	@grpcode varchar(25),
	@grpname varchar(150),
	@grpleadid bigint,
	@isactive bit,
	@cid bigint
AS
BEGIN
	
	declare @name varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(	
		id bigint not null,
		grpcode varchar(25) collate SQL_Latin1_General_CP1_CI_AS not null, 
		grpname varchar(150) collate SQL_Latin1_General_CP1_CI_AS not null, 
		grpleadid bigint,
		isactive bit null, 
		primary key(id, grpcode)
	);

	-- set intial value to variable when update is triggered
	set @name = (select grpname from groups where id = @id);

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, grpcode, grpname, grpleadid, isactive)
		select id, grpcode, grpname, grpleadid, isactive from groups where id != @id 
		union all
		select @id, @grpcode, @grpname, @grpleadid, @isactive; 
	else
		insert into #tmp (id, grpcode, grpname, grpleadid, isactive)
		select id, grpcode, grpname, grpleadid, isactive from groups where id != @id 

	-- merge process
	merge groups as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (grpcode, grpname, grpleadid, isactive, createdbyid, dtcreated)
		values (s.grpcode, s.grpname, s.grpleadid, 1, @cid, getdate())

	when matched and (t.grpcode != s.grpcode or t.grpname != s.grpname or t.grpleadid != s.grpleadid) then
		update
		set t.grpcode = s.grpcode, t.grpname = s.grpname, t.grpleadid = s.grpleadid, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @id = 0
			select 1 as flag, 'Workgroup has been added successfully.' as msg;
		else if @isactive = 1 and @id > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, @name + ' has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @id = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @id > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_tranorderdetails]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: October 1, 2019
-- Description:	Transaction script for Order details
-- =============================================
CREATE PROCEDURE [dbo].[sp_tranorderdetails] 
	@id bigint, 
	@orderid bigint,
	@jobno varchar(25),
	@partno varchar(100),
	@partdesc varchar(max),
	@isactive bit,
	@cid bigint
AS
BEGIN
	
	declare @name varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(	
		id bigint, 
		orderid bigint,
		jobno varchar(25) collate SQL_Latin1_General_CP1_CI_AS not null,
		partno varchar(100) collate SQL_Latin1_General_CP1_CI_AS not null,
		partdesc varchar(max) collate SQL_Latin1_General_CP1_CI_AS null,
		isactive bit,
		primary key(id)
	);

	-- set intial value to variable when update is triggered
	set @name = ('Order item ');

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, orderid, jobno, partno, partdesc, isactive)
		select id, orderid, jobno, partno, partdesc, isactive from orderdetails where id != @id
		union all
		select @id, @orderid, @jobno, @partno, @partdesc, @isactive; 
	else
		insert into #tmp (id, orderid, jobno, partno, partdesc, isactive)
		select id, orderid, jobno, partno, partdesc, isactive from orderdetails where id != @id;

	-- merge process
	merge orderdetails as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (orderid, jobno, partno, partdesc, isactive, createdbyid, dtcreated)
		values (s.orderid, s.jobno, s.partno, s.partdesc, 1, @cid, getdate())

	when matched and (t.orderid != s.orderid or t.jobno != s.jobno or t.partno != s.partno or t.partdesc != s.partdesc) then
		update
		set t.orderid = s.orderid, t.jobno = s.jobno, t.partno = s.partno, t.partdesc = s.partdesc, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @id = 0
			select 1 as flag, @name + ' has been addedd successfully.' as msg;
		else if @isactive = 1 and @id > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, @name + ' has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @id = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @id > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_tranorders]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: October 1, 2019
-- Description:	Transaction script for Orders
-- =============================================
CREATE PROCEDURE [dbo].[sp_tranorders] 
	@id bigint,
	@custid bigint, 
	@custcode varchar(25),
	@orderno varchar(25),
	@quoteno varchar(25),
	@isactive bit,
	@cid bigint
AS
BEGIN
	
	declare @name varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(	
		id bigint not null,
		custid bigint not null, 
		custcode varchar(25) collate SQL_Latin1_General_CP1_CI_AS not null, 
		orderno varchar(25) collate SQL_Latin1_General_CP1_CI_AS not null,
		quoteno varchar(25) collate SQL_Latin1_General_CP1_CI_AS null, 
		isactive bit null, 
		primary key(id)
	);

	-- set intial value to variable when update is triggered
	set @name = ('Order ' + @orderno + ' ');

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, custid, custcode, orderno, quoteno, isactive)
		select id, custid, custcode, orderno, quoteno, isactive from orders where id != @id 
		union all
		select @id, @custid, @custcode, @orderno, @quoteno, @isactive; 
	else
		insert into #tmp (id, custid, custcode, orderno, quoteno, isactive)
		select id, custid, custcode, orderno, quoteno, isactive from orders where id != @id;

	-- merge process
	merge orders as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (custid, custcode, orderno, quoteno, isactive, createdbyid, dtcreated)
		values (s.custid, s.custcode, s.orderno, s.quoteno, 1, @cid, getdate())

	when matched and (t.custid != s.custid or t.custcode != s.custcode or t.orderno != s.orderno or t.quoteno != s.quoteno) then
		update
		set t.custid = s.custid, t.custcode = s.custcode, t.orderno = s.orderno, t.quoteno = s.quoteno, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @id = 0
			select 1 as flag, @name + ' has been addedd successfully.' as msg;
		else if @isactive = 1 and @id > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, @name + ' has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @id = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @id > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_transhifts]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: October 1, 2019
-- Description:	Transaction script for Shifts
-- =============================================
CREATE PROCEDURE [dbo].[sp_transhifts] 
	@id bigint,
	@shiftcode varchar(25),
	@shiftdesc varchar(150),
	@istimebased bit,
	@timestart time,
	@timeend time,
	@isworkweekbased bit,
	@workweekquota float,
	@isflexible bit,
	@workdayquota float,
	@isactive bit,
	@cid bigint
AS
BEGIN
	
	declare @name varchar(150);

	set nocount on;

	-- create table instance
	create table #tmp 
	(	
		id bigint,
		shiftcode varchar(25),
		shiftdesc varchar(150),
		istimebased bit,
		timestart time,
		timeend time,
		isworkweekbased bit,
		workweekquota float,
		isflexible bit,
		workdayquota float,
		isactive bit,
		cid bigint,
		primary key(id, shiftcode)
	);

	-- set intial value to variable when update is triggered
	set @name = (select shiftdesc from shifts where id = @id);

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, shiftcode, shiftdesc, istimebased, timestart, timeend, isworkweekbased, workweekquota, isflexible, workdayquota, isactive)
		select id, shiftcode, shiftdesc, istimebased, timestart, timeend, isworkweekbased, workweekquota, isflexible, workdayquota, isactive from shifts where id != @id 
		union all
		select @id, @shiftcode, @shiftdesc, @istimebased, @timestart, @timeend, @isworkweekbased, @workweekquota, @isflexible, @workdayquota, @isactive; 
	else
		insert into #tmp (id, shiftcode, shiftdesc, istimebased, timestart, timeend, isworkweekbased, workweekquota, isflexible, workdayquota, isactive)
		select id, shiftcode, shiftdesc, istimebased, timestart, timeend, isworkweekbased, workweekquota, isflexible, workdayquota, isactive from shifts where id != @id ;

	-- merge process
	merge shifts as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (shiftcode, shiftdesc, istimebased, timestart, timeend, isworkweekbased, workweekquota, isflexible, workdayquota, isactive, createdbyid, dtcreated)
		values (s.shiftcode, s.shiftdesc, s.istimebased, s.timestart, s.timeend, s.isworkweekbased, s.workweekquota, s.isflexible, s.workdayquota, 1, @cid, getdate())

	when matched and (t.shiftcode != s.shiftcode or t.shiftdesc != s.shiftdesc or t.istimebased != t.istimebased or t.timestart != s.timestart or t.timeend != s.timeend or 
					  t.isworkweekbased != s.isworkweekbased  or t.workweekquota != s.workweekquota or t.isflexible != s.isflexible or t.workdayquota != s.workdayquota) then
		update
		set t.shiftcode = s.shiftcode, t.shiftdesc = s.shiftdesc, t.istimebased = t.istimebased, t.timestart = s.timestart, t.timeend = s.timeend, 
					  t.isworkweekbased = s.isworkweekbased, t.workweekquota = s.workweekquota, t.isflexible = s.isflexible, t.workdayquota = s.workdayquota, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @id = 0
			select 1 as flag, 'Shift has been added successfully.' as msg;
		else if @isactive = 1 and @id > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, @name + ' has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @id = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @id > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;

END
GO
/****** Object:  StoredProcedure [dbo].[sp_tranworkcenter]    Script Date: 10/25/2019 6:28:53 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Romel S. Dela Cruz
-- Create date: September 27, 2019
-- Description:	Transaction script for Work center
-- =============================================
CREATE PROCEDURE [dbo].[sp_tranworkcenter]
	@wcid bigint,
	@wccode varchar(15),
	@wcdesc varchar(100),
	@isactive bit,
	@cid bigint
AS
BEGIN
	
	declare @wcn varchar(100);

	set nocount on;

	-- create table instance
	create table #tmp 
	(	
		id bigint not null, 
		wccode varchar(15) collate SQL_Latin1_General_CP1_CI_AS null, 
		wcdesc varchar(100) collate SQL_Latin1_General_CP1_CI_AS not null,  
		isactive bit null, 
		primary key(id)
	);

	-- set intial value to variable when update is triggered
	set @wcn = (select wcdesc from workcenter where id = @wcid);

	/*
		Populate temporary table

		@isactive
		when 0	: for deletion
		else	: insert / update
	*/
	if @isactive = 1
		insert into #tmp (id, wccode, wccode, isactive)
		select id, wccode, wcdesc, isactive from workcenter where id not in (@wcid) 
		union all
		select @wcid as id, @wccode as wccode, @wcdesc as wcdesc, @isactive as isactive;
	else
		insert into #tmp (id, wccode, wccode, isactive)
		select id, wccode, wcdesc, isactive from workcenter where id not in (@wcid); 

	-- merge process
	merge workcenter as t
	using #tmp as s
	on (t.id = s.id)
	when not matched by target then 
		insert (wccode, wcdesc, isactive, createdbyid, dtcreated)
		values (s.wccode, s.wcdesc, 1, @cid, getdate())

	when matched and (t.wccode != s.wccode or t.wcdesc != s.wcdesc) then
		update
		set t.wccode = s.wccode, t.wcdesc = s.wcdesc, t.modifiedbyid = @cid, t.dtmodified = getdate()

	when not matched by source then
		update
		set t.isactive = 0, t.modifiedbyid = @cid, t.dtmodified = getdate();

	if @@ROWCOUNT > 0 
		if @isactive = 1 and @wcid = 0
			select 1 as flag, @wcdesc + ' has been addedd successfully.' as msg;
		else if @isactive = 1 and @wcid > 0
			select 1 as flag, 'Record has been updated successfully.' as msg;
		else
			select 1 as flag, @wcn + ' has been removed successfully.' as msg;
	else
		select	0 as flag, 
				case 
					when @isactive = 0 then 'Failed to remove selected record from the database. Please contact you system administrator.'
					when @isactive = 1 and @wcid = 0 then 'Failed to insert record from the database. Please contact your system administrator.'
					when @isactive = 1 and @wcid > 0 then 'Failed to update record from the database. Please contact your system administrator.'
					else 'Unhandled error occured. Please contact your system administrator.' 
				end as msg;

	drop table #tmp;

	set nocount off;
END
GO
USE [master]
GO
ALTER DATABASE [saptz] SET  READ_WRITE 
GO
