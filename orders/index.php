
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	
	<title>Hainzer Supply Orders</title>
	
	<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
	 <link href="//cdn.virtuosoft.eu/virtuosoft.eu/resources/prettify/prettify.css" rel="stylesheet" type="text/css" media="all">
	<link href="http://www.virtuosoft.eu/code/bootstrap-touchspin/bootstrap-touchspin/v3.0.1/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all">
	
	<link href="css/simple-sidebar.css" rel="stylesheet">
	<style type="text/css" class="init">
		body{ padding:0px 10px;}
		.td_price{width:120px; margin:auto;}
		
		
	</style>
	
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.0.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js">
	</script>
	<script src="//cdn.virtuosoft.eu/virtuosoft.eu/resources/prettify/prettify.js"></script>
	<script src="http://www.virtuosoft.eu/code/bootstrap-touchspin/bootstrap-touchspin/v3.0.1/jquery.bootstrap-touchspin.js"></script>
	<script type="text/javascript" class="init">
$(document).ready(function() {
	$('#example').DataTable({
        "lengthMenu": [[50, -1], [50, "All"]]
    });
	
	
} );

	</script>
</head>
<body>


<div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
		
            <ul class="sidebar-nav">			
                <li class="sidebar-brand"  style="font-size:13px; color:#999">				                    
        <h3 style="color:orange;"><span class="glyphicon glyphicon-shopping-cart"></span> Order Detail</h3>
		<table class="table" >
			<tr>
				<td>Productos<br> s/promoción</td>
				<td align="right">$<span id="span_prod_s_prom">   0 </span></td>
			</tr>
			<tr>
				<td>Descuento</td>
				<td align="right">$<span id="span_desc">  0 </span></td>
			</tr>
			<tr>
				<td>Productos<br> s/promoción c/descuento</td>
				<td align="right">$<span id="span_prod_s_prom_c_desc">  0 </span></td>
			</tr>
			<tr>
				<td>Productos<br> c/promoción</td>
				<td align="right">$<span id="span_prod_c_prom">  0 </span></td>
			</tr>
			<tr>
				<td>Total Pedido</td>
				<td align="right">$<span id="span_total_ped">  0 </span></td>
			</tr>
			<tr>
				<td>IVA</td>
				<td align="right">$<span id="span_iva">  0 </span></td>
			</tr>
			<tr>
				<td><b>Total final</b></td>
				<td align="right"><b>$<span id="span_total_final">  0 </span></b></td>
			</tr>
		</table>                    
                </li>
                
            </ul>
        </div>
		<!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
				<h3 class="page_title"> <img src="http://ingenierosencomputacion.com.mx/login/img/logo.png" width="50" /> Hainzer Supply Orders <a style="float:right;" href="#menu-toggle" class="btn btn-sm btn-warning" id="menu-toggle"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Order Detail</a></h3> 

				
				
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>SKU</th>
							<th>Name</th>
							<th>Color</th>
							<th>Size</th>
							<th>Stock</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Order</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>SKU</th>
							<th>Name</th>
							<th>Color</th>
							<th>Size</th>
							<th>Stock</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Order</th>
						</tr>
					</tfoot>
					<tbody>
						<tr>
							<td>Tiger Nixon</td>
							<td>System Architect</td>
							<td>Edinburgh</td>
							<td>61</td>
							<td>25</td>
							<td><div class="td_price"><input id="demo3" type="text" value="" name="demo3"></div></td>
							<td>$320,800</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span> <span class="glyphicon glyphicon-tags"></span></td>
						</tr>
					
						<tr>
							<td>Garrett Winters</td>
							<td>Accountant</td>
							<td>Tokyo</td>
							<td>63</td>
							<td>25</td>
							<td><div class="td_price"><input id="demo4" type="text" value="" name="demo4"></div></td>
							<td>$170,750</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span> <span class="glyphicon glyphicon-tags"></span></td>
						</tr>
						<tr>
							<td>Ashton Cox</td>
							<td>Junior Technical Author</td>
							<td>San Francisco</td>
							<td>66</td>
							<td>12</td>
							<td><div class="td_price"><input id="demo5" type="text" value="" name="demo5"></div></td>
							<td>$86,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span> <span class="glyphicon glyphicon-tags"></span></td>
						</tr>
						<tr>
							<td>Cedric Kelly</td>
							<td>Senior Javascript Developer</td>
							<td>Edinburgh</td>
							<td>22</td>
							<td>29</td>
							<td><div class="td_price"><input id="demo3" type="text" value="" name="demo3"></div></td>
							<td>$433,060</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
							
						<tr>
							<td>Airi Satou</td>
							<td>Accountant</td>
							<td>Tokyo</td>
							<td>33</td>
							<td>28</td>
							<td><div class="td_price"><input id="demo3" type="text" value="" name="demo3"></div></td>
							<td>$162,700</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span> <span class="glyphicon glyphicon-tags"></td>
						</tr>
						<tr>
							<td>Brielle Williamson</td>
							<td>Integration Specialist</td>
							<td>New York</td>
							<td>61</td>
							<td>02</td>
							<td><div class="td_price"><input id="demo3" type="text" value="" name="demo3"></div></td>
							<td>$372,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span> <span class="glyphicon glyphicon-tags"></span></td>
						</tr>
						<tr>
							<td>Herrod Chandler</td>
							<td>Sales Assistant</td>
							<td>San Francisco</td>
							<td>59</td>
							<td>06</td>
							<td><div class="td_price"><input id="demo3" type="text" value="" name="demo3"></div></td>
							<td>$137,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Rhona Davidson</td>
							<td>Integration Specialist</td>
							<td>Tokyo</td>
							<td>55</td>
							<td>14</td>
							<td><div class="td_price"><input id="demo3" type="text" value="" name="demo3"></div></td>
							<td>$327,900</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Colleen Hurst</td>
							<td>Javascript Developer</td>
							<td>San Francisco</td>
							<td>39</td>
							<td>15</td>
							<td><div class="td_price"><input id="demo3" type="text" value="" name="demo3"></div></td>
							<td>$205,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Sonya Frost</td>
							<td>Software Engineer</td>
							<td>Edinburgh</td>
							<td>23</td>
							<td>13</td>
							<td><div class="td_price"><input id="demo3" type="text" value="" name="demo3"></div></td>
							<td>$103,600</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Jena Gaines</td>
							<td>Office Manager</td>
							<td>London</td>
							<td>30</td>
							<td>19</td>
							<td>$90,560</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Quinn Flynn</td>
							<td>Support Lead</td>
							<td>Edinburgh</td>
							<td>22</td>
							<td>03</td>
							<td>$342,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Charde Marshall</td>
							<td>Regional Director</td>
							<td>San Francisco</td>
							<td>36</td>
							<td>16</td>
							<td>$470,600</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Haley Kennedy</td>
							<td>Senior Marketing Designer</td>
							<td>London</td>
							<td>43</td>
							<td>18</td>
							<td>$313,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Tatyana Fitzpatrick</td>
							<td>Regional Director</td>
							<td>London</td>
							<td>19</td>
							<td>17</td>
							<td>$385,750</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Michael Silva</td>
							<td>Marketing Designer</td>
							<td>London</td>
							<td>66</td>
							<td>27</td>
							<td>$198,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Paul Byrd</td>
							<td>Chief Financial Officer (CFO)</td>
							<td>New York</td>
							<td>64</td>
							<td>9</td>
							<td>$725,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Gloria Little</td>
							<td>Systems Administrator</td>
							<td>New York</td>
							<td>59</td>
							<td>10</td>
							<td>$237,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Bradley Greer</td>
							<td>Software Engineer</td>
							<td>London</td>
							<td>41</td>
							<td>13</td>
							<td>$132,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Dai Rios</td>
							<td>Personnel Lead</td>
							<td>Edinburgh</td>
							<td>35</td>
							<td>26</td>
							<td>$217,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Jenette Caldwell</td>
							<td>Development Lead</td>
							<td>New York</td>
							<td>30</td>
							<td>03</td>
							<td>$345,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Yuri Berry</td>
							<td>Chief Marketing Officer (CMO)</td>
							<td>New York</td>
							<td>40</td>
							<td>25</td>
							<td>$675,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Caesar Vance</td>
							<td>Pre-Sales Support</td>
							<td>New York</td>
							<td>21</td>
							<td>12</td>
							<td>$106,450</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Doris Wilder</td>
							<td>Sales Assistant</td>
							<td>Sidney</td>
							<td>23</td>
							<td>20</td>
							<td>$85,600</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Angelica Ramos</td>
							<td>Chief Executive Officer (CEO)</td>
							<td>London</td>
							<td>47</td>
							<td>9</td>
							<td>$1,200,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Gavin Joyce</td>
							<td>Developer</td>
							<td>Edinburgh</td>
							<td>42</td>
							<td>22</td>
							<td>$92,575</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Jennifer Chang</td>
							<td>Regional Director</td>
							<td>Singapore</td>
							<td>28</td>
							<td>14</td>
							<td>$357,650</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Brenden Wagner</td>
							<td>Software Engineer</td>
							<td>San Francisco</td>
							<td>28</td>
							<td>07</td>
							<td>$206,850</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Fiona Green</td>
							<td>Chief Operating Officer (COO)</td>
							<td>San Francisco</td>
							<td>48</td>
							<td>11</td>
							<td>$850,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Shou Itou</td>
							<td>Regional Marketing</td>
							<td>Tokyo</td>
							<td>20</td>
							<td>14</td>
							<td>$163,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Michelle House</td>
							<td>Integration Specialist</td>
							<td>Sidney</td>
							<td>37</td>
							<td>2</td>
							<td>$95,400</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Suki Burks</td>
							<td>Developer</td>
							<td>London</td>
							<td>53</td>
							<td>22</td>
							<td>$114,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Prescott Bartlett</td>
							<td>Technical Author</td>
							<td>London</td>
							<td>27</td>
							<td>7</td>
							<td>$145,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Gavin Cortez</td>
							<td>Team Leader</td>
							<td>San Francisco</td>
							<td>22</td>
							<td>26</td>
							<td>$235,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Martena Mccray</td>
							<td>Post-Sales support</td>
							<td>Edinburgh</td>
							<td>46</td>
							<td>9</td>
							<td>$324,050</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Unity Butler</td>
							<td>Marketing Designer</td>
							<td>San Francisco</td>
							<td>47</td>
							<td>9</td>
							<td>$85,675</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Howard Hatfield</td>
							<td>Office Manager</td>
							<td>San Francisco</td>
							<td>51</td>
							<td>16</td>
							<td>$164,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Hope Fuentes</td>
							<td>Secretary</td>
							<td>San Francisco</td>
							<td>41</td>
							<td>12</td>
							<td>$109,850</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Vivian Harrell</td>
							<td>Financial Controller</td>
							<td>San Francisco</td>
							<td>62</td>
							<td>14</td>
							<td>$452,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Timothy Mooney</td>
							<td>Office Manager</td>
							<td>London</td>
							<td>37</td>
							<td>11</td>
							<td>$136,200</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Jackson Bradshaw</td>
							<td>Director</td>
							<td>New York</td>
							<td>65</td>
							<td>26</td>
							<td>$645,750</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Olivia Liang</td>
							<td>Support Engineer</td>
							<td>Singapore</td>
							<td>64</td>
							<td>3</td>
							<td>$234,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Bruno Nash</td>
							<td>Software Engineer</td>
							<td>London</td>
							<td>38</td>
							<td>3</td>
							<td>$163,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Sakura Yamamoto</td>
							<td>Support Engineer</td>
							<td>Tokyo</td>
							<td>37</td>
							<td>19</td>
							<td>$139,575</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Thor Walton</td>
							<td>Developer</td>
							<td>New York</td>
							<td>61</td>
							<td>11</td>
							<td>$98,540</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Finn Camacho</td>
							<td>Support Engineer</td>
							<td>San Francisco</td>
							<td>47</td>
							<td>7</td>
							<td>$87,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Serge Baldwin</td>
							<td>Data Coordinator</td>
							<td>Singapore</td>
							<td>64</td>
							<td>9</td>
							<td>$138,575</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Zenaida Frank</td>
							<td>Software Engineer</td>
							<td>New York</td>
							<td>63</td>
							<td>4</td>
							<td>$125,250</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Zorita Serrano</td>
							<td>Software Engineer</td>
							<td>San Francisco</td>
							<td>56</td>
							<td>1</td>
							<td>$115,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Jennifer Acosta</td>
							<td>Junior Javascript Developer</td>
							<td>Edinburgh</td>
							<td>43</td>
							<td>1</td>
							<td>$75,650</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Cara Stevens</td>
							<td>Sales Assistant</td>
							<td>New York</td>
							<td>46</td>
							<td>6</td>
							<td>$145,600</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Hermione Butler</td>
							<td>Regional Director</td>
							<td>London</td>
							<td>47</td>
							<td>21</td>
							<td>$356,250</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Lael Greer</td>
							<td>Systems Administrator</td>
							<td>London</td>
							<td>21</td>
							<td>27</td>
							<td>$103,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Jonas Alexander</td>
							<td>Developer</td>
							<td>San Francisco</td>
							<td>30</td>
							<td>14</td>
							<td>$86,500</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Shad Decker</td>
							<td>Regional Director</td>
							<td>Edinburgh</td>
							<td>51</td>
							<td>13</td>
							<td>$183,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Michael Bruce</td>
							<td>Javascript Developer</td>
							<td>Singapore</td>
							<td>29</td>
							<td>27</td>
							<td>$183,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
						<tr>
							<td>Donna Snider</td>
							<td>Customer Support</td>
							<td>New York</td>
							<td>27</td>
							<td>25</td>
							<td>$112,000</td>
							<td><span class="glyphicon glyphicon-shopping-cart"></span></td>
						</tr>
					</tbody>
				</table>
		
</div>
                </div>
            </div>
        </div>
</body>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
	 $("input[name='demo3']").TouchSpin({
				initval: 1,
                min: 1,
                max: 999,
              
            });
			$("input[name='demo4']").TouchSpin({
				initval: 1,
                min: 1,
                max: 100,
              
            });
			$("input[name='demo5']").TouchSpin({
				initval: 1,
                min: 1,
                max: 100,
              
            });
	
    </script>
</html>