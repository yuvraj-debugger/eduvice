<div>
	<table class="table table-borderd">
		<tr>
			<th>Title</th>
			<td>{{$globalCourse->title}}</td>
		</tr>
		<tr>
		     <th>Highest Education</th>
		     <td><?php if($globalCourse->mark_grade == '1'){
					    echo "High School";
					}elseif ($globalCourse->mark_grade =='2'){
					    echo "Graduation";
					}else{
					    echo "Post Graduation";
					}
					?></td>
		</tr>
		
		<tr>
			<th>Created At</th>
			<td>{{$globalCourse->created_at}}</td>
		</tr>
	</table>
</div>
