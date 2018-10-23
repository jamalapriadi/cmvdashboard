@extends('layouts.program.main')


@section('css')
@stop


@section('js')

<script>

	$(function(){

		$("#program").select2({
			placeholder: "Search for a program",
			ajax: {
				url: "{{URL::to('program/data/list-program')}}",
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return  {
	              q: params, // search term
	              page_limit: 10,
	          };
	      },
	      results: function (data, page){
	      	return {
	      		results: data.data
	      	};
	      },
	      cache: true,
	      pagination: {
	      	more: true
	      }
	  },
	  formatResult: function(m){
	  	var markup="<option value='"+m.id+"'>"+m.text+"</option>"; 
	  	return markup;
	  },
	  formatSelection: function(m){
	  	return m.text;
	  },
	  escapeMarkup: function (m) { return m; }
	});

		$('.daterange-buttons').daterangepicker({
                opens: 'left',
			
			applyClass: 'btn-success',
			cancelClass: 'btn-danger'
		});






	})




</script>
@stop


@section('content')
<div class="container-fluid">
	<!-- OVERVIEW -->
	<div class="panel-header">
		<h5 class="panel-title text-center">SUMMARY</h5>
	</div>
	<div class="panel-body">
		<form id="formTargetAchievement" onsubmit="return false">
			<div class="row">
				<div class="col-lg-3">
					<div class="form-group">
						<label class="control-label">Program</label>
						<input type="text" class="data-program" name="program" id="program">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group">
						<label class="control-label">Periode</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-calendar22"></i></span>
							<input type="text" name="periode" class="form-control daterange-buttons">
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<button class='btn btn-primary' style="margin-top:25px;">
						<i class="icon-filter4"></i> &nbsp;
						Filter 
					</button>
				</div>
			</div>
		</form>


		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">PROGRAM SUMMARY</h5>
				<div class="heading-elements">
					<ul class="icons-list">
						<li><a data-action="collapse"></a></li>
						<li><a data-action="reload"></a></li>
						<li><a data-action="close"></a></li>
					</ul>
				</div>
			</div>

			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-framed">
						<thead>
							<tr>
								<th>PARAMETER</th>
								<th>RESULT</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>TV Channel</td>
								<td>Eugene</td>
							</tr>
							<tr>
								<td>Tier TV</td>
								<td>Eugene</td>
							</tr>
							<tr>
								<td>Target Audience</td>
								<td>Eugene</td>
							</tr>
							<tr>
								<td>Rank in AllTV for All Genre</td>
								<td>Eugene</td>
							</tr>
							<tr>
								<td>Rank in Tier 1 for All Genre</td>
								<td>Eugene</td>
							</tr>
							<tr>
								<td>Rank in AllTV for Genre Series</td>
								<td>Eugene</td>
							</tr>
							<tr>
								<td>Rank in Tier 1 for Genre Series</td>
								<td>Eugene</td>
							</tr>
							<tr>
								<td>Rank in AllTV for Genre Series : Drama</td>
								<td>Eugene</td>
							</tr>
							<tr>
								<td>Rank in Tier 1 for Genre Series : Drama</td>
								<td>Eugene</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">AUDIENCE PROFILING</h5>
				<div class="heading-elements">
					<ul class="icons-list">
						<li><a data-action="collapse"></a></li>
						<li><a data-action="reload"></a></li>
						<li><a data-action="close"></a></li>
					</ul>
				</div>
			</div>

			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-framed">
						<thead>
							<tr>
								<th colspan="2">TA</th>
								<th>INDEX</th>
								<th>TVR</th>
								<th>000s</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td rowspan="2">GENDER</td>
								<td>FEMALE</td>
								<td>85</td>
								<td>2.9</td>
								<td>702</td>
							</tr>
							<tr>
								<td>MALE</td>
								<td style="background:#008ef6;color:white">115</td>
								<td style="background:#4ac519;color:white">4</td>
								<td style="background:#d9a710;color:white">990</td>
							</tr>
							<tr>
								<td rowspan="3">SEC</td>
								<td>SEC UP</td>
								<td>87</td>
								<td>3</td>
								<td>357</td>
							</tr>
							<tr>
								<td>SEC MID</td>
								<td style="background:#008ef6;color:white">108</td>
								<td style="background:#4ac519;color:white">3.7</td>
								<td style="background:#d9a710;color:white">1147</td>
							</tr>
							<tr>
								<td>SEC LOW</td>
								<td>85</td>
								<td>3</td>
								<td>188</td>
							</tr>
							<tr>
								<td rowspan="6">AGE</td>
								<td>AGE 15-24</td>
								<td>82</td>
								<td>2.8</td>
								<td>281</td>
							</tr>
							<tr>
								<td>AGE 25-34</td>
								<td>78</td>
								<td>2.7</td>
								<td>224</td>
							</tr>
							<tr>
								<td>AGE 25-34</td>
								<td>78</td>
								<td>2.7</td>
								<td>224</td>
							</tr>
							<tr>
								<td>AGE 35-44</td>
								<td style="background:#008ef6;color:white">111</td>
								<td>3.8</td>
								<td style="background:#d9a710;color:white">340</td>
							</tr>
							<tr>
								<td>AGE 45-54</td>
								<td style="background:#008ef6;color:white">115</td>
								<td>4</td>
								<td>277</td>
							</tr>
							<tr>
								<td>AGE 55-60+</td>
								<td style="background:#008ef6;color:white">147</td>
								<td style="background:#4ac519;color:white">5.1</td>
								<td>279</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">ALL GENRE</h5>
				<div class="heading-elements">
					<ul class="icons-list">
						<li><a data-action="collapse"></a></li>
						<li><a data-action="reload"></a></li>
						<li><a data-action="close"></a></li>
					</ul>
				</div>
			</div>

			<div class="panel-body">
				<p>+ TOP 20 PROGRAM in ALLTV for ALL GENRE +</p>
				<div class="table-responsive">
					<table class="table table-bordered table-framed">
						<thead>
							<tr>
								<th rowspan="2">NO</th>
								<th rowspan="2">PROGRAM</th>
								<th rowspan="2">CHANNEL</th>
								<th rowspan="2">DAYPART</th>
								<th rowspan="2">TVR</th>
								<th rowspan="2">SHARE</th>
								<th colspan="7">INDEX</th>
							</tr>
							<tr>
								<th>F 15+ UM</th>
								<th>M 15+ UM</th>
								<th>MF 15+ UM</th>
								<th>KIDS 5-14 UM</th>
								<th>TEEN 15-24 UM</th>
								<th>MWK < 10 UM</th>
								<th>WHM UM</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>CHANDRA NANDINI</td>
								<td>ANTV</td>
								<td>NPT</td>
								<td>4.8</td>
								<td>18.8</td>
								<td>127</td>
								<td>72</td>
								<td>100</td>
								<td>91</td>
								<td>82</td>
								<td style="background-color: #f2667d;color:white;">175</td>
								<td>139</td>
							</tr>
							<tr>
								<td>2</td>
								<td>ANAK LANGIT</td>
								<td>SCTV</td>
								<td>PT</td>
								<td>4.5</td>
								<td>16.9</td>
								<td style="background-color: #f2667d;color:white;">111</td>
								<td>78</td>
								<td>95</td>
								<td>88</td>
								<td>94</td>
								<td>92</td>
								<td>108</td>
							</tr>
							<tr>
								<td>3</td>
								<td>ORANG KETIGA</td>
								<td>SCTV</td>
								<td>PT</td>
								<td>4.4</td>
								<td>22.1</td>
								<td>129</td>
								<td>79</td>
								<td>105</td>
								<td>81</td>
								<td>85</td>
								<td>70</td>
								<td style="background-color: #f2667d;color:white;">133</td>
							</tr>
							<tr>
								<td>4</td>
								<td>SIAPA TAKUT JATUH CINTA</td>
								<td>SCTV</td>
								<td>PT</td>
								<td>3.9</td>
								<td>17.2</td>
								<td>115</td>
								<td>74</td>
								<td>95</td>
								<td>87</td>
								<td>89</td>
								<td>92</td>
								<td style="background-color: #f2667d;color:white;">118</td>
							</tr>
							<tr>
								<td>5</td>
								<td>DUNIA TERBALIK</td>
								<td>RCTI</td>
								<td>PT</td>
								<td>3.7</td>
								<td>14.6</td>
								<td>124</td>
								<td>85</td>
								<td>105</td>
								<td>92</td>
								<td>79</td>
								<td>64</td>
								<td style="background-color: #f2667d;color:white;">146</td>
							</tr>
							<tr>
								<td>6</td>
								<td>JODOH</td>
								<td>ANTV</td>
								<td>PT</td>
								<td>3</td>
								<td>13.6</td>
								<td>127</td>
								<td>91</td>
								<td>110</td>
								<td>78</td>
								<td>104</td>
								<td>122</td>
								<td style="background-color: #f2667d;color:white;">138</td>
							</tr>
						</tbody>
					</table>
					<p>Rank of DUNIA TERBALIK in ALLTV for All Genre Program is 5</p>
				</div>
			</div>

			<div class="panel-body">
				<p>+ TOP 20 PROGRAM in TIER 1 for ALL GENRE +</p>
				<div class="table-responsive">
					<table class="table table-bordered table-framed">
						<thead>
							<tr>
								<th rowspan="2">NO</th>
								<th rowspan="2">PROGRAM</th>
								<th rowspan="2">CHANNEL</th>
								<th rowspan="2">DAYPART</th>
								<th rowspan="2">TVR</th>
								<th rowspan="2">SHARE</th>
								<th colspan="7">INDEX</th>
							</tr>
							<tr>
								<th>F 15+ UM</th>
								<th>M 15+ UM</th>
								<th>MF 15+ UM</th>
								<th>KIDS 5-14 UM</th>
								<th>TEEN 15-24 UM</th>
								<th>MWK < 10 UM</th>
								<th>WHM UM</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>CHANDRA NANDINI</td>
								<td>ANTV</td>
								<td>NPT</td>
								<td>4.8</td>
								<td>18.8</td>
								<td>127</td>
								<td>72</td>
								<td>100</td>
								<td>91</td>
								<td>82</td>
								<td>175</td>
								<td>139</td>
							</tr>
							<tr>
								<td>2</td>
								<td>ANAK LANGIT</td>
								<td>SCTV</td>
								<td>PT</td>
								<td>4.5</td>
								<td>16.9</td>
								<td>111</td>
								<td>78</td>
								<td>95</td>
								<td>88</td>
								<td>94</td>
								<td>92</td>
								<td>108</td>
							</tr>
							
						</tbody>
					</table>
					Rank of DUNIA TERBALIK  in  tier 1 for All Genre Program is ....
				</div>
			</div>
		</div>

		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">GENRE LEVEL 1</h5>
				<div class="heading-elements">
					<ul class="icons-list">
						<li><a data-action="collapse"></a></li>
						<li><a data-action="reload"></a></li>
						<li><a data-action="close"></a></li>
					</ul>
				</div>
			</div>

			<div class="panel-body">
				<p>+ TOP 20 PROGRAM in ALLTV for GENRE SERIES (tergantung program yg d pilih) +</p>
				<div class="table-responsive">
					<table class="table table-bordered table-framed">
						<thead>
							<tr>
								<th rowspan="2">NO</th>
								<th rowspan="2">PROGRAM</th>
								<th rowspan="2">CHANNEL</th>
								<th rowspan="2">DAYPART</th>
								<th rowspan="2">TVR</th>
								<th rowspan="2">SHARE</th>
								<th colspan="7">INDEX</th>
							</tr>
							<tr>
								<th>F 15+ UM</th>
								<th>M 15+ UM</th>
								<th>MF 15+ UM</th>
								<th>KIDS 5-14 UM</th>
								<th>TEEN 15-24 UM</th>
								<th>MWK < 10 UM</th>
								<th>WHM UM</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
							</tr>
						</tbody>
					</table>
					<p>Rank of DUNIA TERBALIK  in ALLTV for Genre Series is ....</p>
				</div>
			</div>

			<div class="panel-body">
				<p>+ TOP 20 PROGRAM in TIER 1 for GENRE SERIES (tergantung program yg d pilih) +</p>
				<div class="table-responsive">
					<table class="table table-bordered table-framed">
						<thead>
							<tr>
								<th rowspan="2">NO</th>
								<th rowspan="2">PROGRAM</th>
								<th rowspan="2">CHANNEL</th>
								<th rowspan="2">DAYPART</th>
								<th rowspan="2">TVR</th>
								<th rowspan="2">SHARE</th>
								<th colspan="7">INDEX</th>
							</tr>
							<tr>
								<th>F 15+ UM</th>
								<th>M 15+ UM</th>
								<th>MF 15+ UM</th>
								<th>KIDS 5-14 UM</th>
								<th>TEEN 15-24 UM</th>
								<th>MWK < 10 UM</th>
								<th>WHM UM</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
							</tr>
						</tbody>
					</table>
					<p>Rank of DUNIA TERBALIK  in Tier 1 for Genre Series is ....</p>
				</div>
			</div>
		</div>

		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">GENRE LEVEL 2</h5>
				<div class="heading-elements">
					<ul class="icons-list">
						<li><a data-action="collapse"></a></li>
						<li><a data-action="reload"></a></li>
						<li><a data-action="close"></a></li>
					</ul>
				</div>
			</div>

			<div class="panel-body">
				<p>+ TOP 20 PROGRAM in ALLTV for GENRE SERIES (tergantung program yg d pilih) +</p>
				<div class="table-responsive">
					<table class="table table-bordered table-framed">
						<thead>
							<tr>
								<th rowspan="2">NO</th>
								<th rowspan="2">PROGRAM</th>
								<th rowspan="2">CHANNEL</th>
								<th rowspan="2">DAYPART</th>
								<th rowspan="2">TVR</th>
								<th rowspan="2">SHARE</th>
								<th colspan="7">INDEX</th>
							</tr>
							<tr>
								<th>F 15+ UM</th>
								<th>M 15+ UM</th>
								<th>MF 15+ UM</th>
								<th>KIDS 5-14 UM</th>
								<th>TEEN 15-24 UM</th>
								<th>MWK < 10 UM</th>
								<th>WHM UM</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
							</tr>
						</tbody>
					</table>
					<p>Rank of DUNIA TERBALIK  in ALLTV for Genre Series is ....</p>
				</div>
			</div>

			<div class="panel-body">
				<p>+ TOP 20 PROGRAM in TIER 1 for GENRE SERIES (tergantung program yg d pilih) +</p>
				<div class="table-responsive">
					<table class="table table-bordered table-framed">
						<thead>
							<tr>
								<th rowspan="2">NO</th>
								<th rowspan="2">PROGRAM</th>
								<th rowspan="2">CHANNEL</th>
								<th rowspan="2">DAYPART</th>
								<th rowspan="2">TVR</th>
								<th rowspan="2">SHARE</th>
								<th colspan="7">INDEX</th>
							</tr>
							<tr>
								<th>F 15+ UM</th>
								<th>M 15+ UM</th>
								<th>MF 15+ UM</th>
								<th>KIDS 5-14 UM</th>
								<th>TEEN 15-24 UM</th>
								<th>MWK < 10 UM</th>
								<th>WHM UM</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
							</tr>
						</tbody>
					</table>
					<p>Rank of DUNIA TERBALIK  in Tier 1 for Genre Series is ....</p>
				</div>
			</div>
		</div>




	</div>
</div>


@endsection


