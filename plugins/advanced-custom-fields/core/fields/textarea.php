<?php

class acf_Textarea extends acf_Field
{

	/*--------------------------------------------------------------------------------------
	*
	*	Constructor
	*
	*	@author Elliot Condon
	*	@since 1.0.0
	*	@updated 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function __construct($parent)
	{
    	parent::__construct($parent);
    	
    	$this->name = 'textarea';
		$this->title = __("Text Area",'acf');
		
   	}
   	
   	
	/*--------------------------------------------------------------------------------------
	*
	*	create_field
	*
	*	@author Elliot Condon
	*	@since 2.0.5
	*	@updated 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function create_field($field)
	{
		// remove unwanted <br /> tags
		$field['value'] = str_replace('<br />','',$field['value']);
		echo '<textarea id="' . $field['name'] . '" rows="4" class="' . $field['class'] . '" name="' . $field['name'] . '" >' . $field['value'] . '</textarea>';
	}
	
	
	/*--------------------------------------------------------------------------------------
	*
	*	create_options
	*
	*	@author Elliot Condon
	*	@since 2.0.6
	* 
	*-------------------------------------------------------------------------------------*/
	
	function create_options($key, $field)
	{
		// defaults
		$field['default_value'] = isset($field['default_value']) ? $field['default_value'] : '';
		$field['formatting'] = isset($field['formatting']) ? $field['formatting'] : 'br';
		
		?>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Default Value",'acf'); ?></label>
			</td>
			<td>
				<?php 
				$this->parent->create_field(array(
					'type'	=>	'textarea',
					'name'	=>	'fields['.$key.'][default_value]',
					'value'	=>	$field['default_value'],
				));
				?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Formatting",'acf'); ?></label>
				<p class="description"><?php _e("Define how to render html tags / new lines",'acf'); ?></p>
			</td>
			<td>
				<?php 
				$this->parent->create_field(array(
					'type'	=>	'select',
					'name'	=>	'fields['.$key.'][formatting]',
					'value'	=>	$field['formatting'],
					'choices' => array(
						'none'	=>	'None',
						'br'	=>	'auto &lt;br /&gt;',
						'html'	=>	'HTML',
					)
				));
				?>
			</td>
		</tr>
		<?php
	}
	
	
	/*--------------------------------------------------------------------------------------
	*
	*	get_value_for_api
	*
	*	@author Elliot Condon
	*	@since 3.0.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function get_value_for_api($post_id, $field)
	{
		// vars
		$format = isset($field['formatting']) ? $field['formatting'] : 'br';
		
		$value = parent::get_value($post_id, $field);
		
		if($format == 'none')
		{
			$value = htmlspecialchars($value, ENT_QUOTES);
		}
		elseif($format == 'html')
		{
			$value = html_entity_decode($value);
		}
		elseif($format == 'br')
		{
			$value = htmlspecialchars($value, ENT_QUOTES);
			$value = nl2br($value);
		}

		return $value;
	}
}

?>