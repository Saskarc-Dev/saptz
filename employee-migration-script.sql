insert into employees
	(empcode, emppwd, roleid, empFN, empLN, isexec, addr, city, state, zipcode, country, phoneno, ssno, hrrate, deptid, shiftid, jobpost, datehired, dateleft, isactive, pwdchanged, createdbyid, dtcreated)
select
	emplcode as ec,
	encryptbypassphrase('SAPTZ', 'password') as pw,
	3 as rid,
	rtrim(substring(emplname, 1, charindex(' ', emplname))) as fn,
	ltrim(substring(emplname, charindex(' ', emplname), len(emplname))) as ln,
	0 as ie,
	ltrim(rtrim(isnull(ltrim(rtrim(addr1)), '') + ' ' + isnull(ltrim(rtrim(addr2)), ''))) as addr,
	city,
	state,
	zipcode, 
	country,
	phone,
	ssn,
	rate1,
	case a.DeptNum
		when  1 then 18
		when 10 then 14
		when 11 then 7
		when  2 then 7
		when  3 then 6
		when  4 then 7
		when  5 then 8
		when  6 then 2
		when  7 then 15
		when  8 then 10
		when  9 then 11
		else 0
	end as dept,
	shift,
	isnull(user_text1, 'N/A') as jp,
	hiredate as hd,
	termdate as td,
	case a.Active when 'N' then 0 else 1 end as ia,
	0 as pc,
	0 as cb,
	getdate() as dtc
from e2shop.dbo.emplcode as a

select * from saptz.dbo.department
select * from e2shop.dbo.dept

select * from e2shop.dbo.EmplCode

truncate table saptz.dbo.employees

update employees set emppwd = hashbytes('SHA2_512', 'Welcome@123')

select DECRYPTBYPASSPHRASE('SAPTZ', encryptbypassphrase('SAPTZ', 'Welcome@123')) as pwd

select convert(varchar(128), decryptbypassphrase('SAPTZ', encryptbypassphrase('SAPTZ', 'Welcome@123')))
