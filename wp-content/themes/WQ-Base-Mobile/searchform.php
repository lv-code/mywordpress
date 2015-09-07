<form method="get" id="searchform" class="search" action="<?php bloginfo('home');?>/">
		<input type="text" name="s" class="keyword"  onblur="if(this.value =='')this.value='Search...and Enter';this.style.background='#DDDDDD'" onfocus="this.value='';this.style.background='#FFFFFF'" onclick="if(this.value=='Search...and Enter')this.value=''" value="Search...and Enter" />
		<input type="submit" name="submit" value="搜寻" class="submit" />
</form>
