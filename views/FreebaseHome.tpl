
<div align="center">
<h1>FreeBase Home</h1>
</div>
{msg}

{$response->form|form}

<table class="table table-striped">  
        <tr>  
        <th>ID</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Height</th>
        <th>Profession</th>
        <th>DOB</th>
        <th>Place of Birth</th>
        <th>Ethnicity</th>
        <th>Nationality</th>
        <th>Places Lived</th>
        <th>Types</th>
    </tr>
    
{foreach from=$response->data item=person}
<td>{$person["id"]}</td>
    <td>{$person["name"]}</td>
    <td>{$person["gender"]}</td>
    <td>{$person["height_meters"]}</td>
    <td>{$person["profession"]}</td>
    <td>{$person["date_of_birth"]}</td>
    <td>{$person["place_of_birth"]}</td>
    <td>{foreach from=$person["ethnicity"] item=h} {$h},{/foreach}</td>
    <td>{foreach from=$person["nationality"] item=h} {$h},{/foreach}</td>
    <td>{foreach from=$person["places_lived"] item=h} {$h},{/foreach}</td>
    <td>
    <a role="button" class="btn btn-primary launch">Show types associated</a>
      
    
    <div id="myModal" class="myModal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          x
        </button>
        <h3 id="myModalLabel">Types</h3>
      </div>
      <div class="modal-body">
        <p>
          {$count=1}
          {foreach from=$person["types"] item=h}
            {foreach from=$h item=p}
              {$count} . {$p} <br>
            {/foreach}
            {$count=$count+1}
          {/foreach}
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">
          Close
        </button>
      </div>
    </div>
    
      
      
    </td>
  </tr>
 {/foreach} 
</table>       