<?php
namespace App\Admin\Helpers;

use App\Admin\Services\ValidationErrors;

use Collective\Html\FormFacade;

class Form extends FormFacade
{
	/* Helpers */
	public static function addClass(&$options, $class = 'form-control')
	{
		if(isset($options['class'])) {
			$options['class'] .= ' ' . $class;
		} else {
			$options['class'] = $class;
		}
	}

	public static function addIdentifier(&$options, $name)
	{
		$options['id'] = $name;
	}
	
	public static function addParentElement($cols = 8, $offset = null)
	{
		$offset = ($offset) ? ' col-sm-offset-' . $offset : null;
		
		return '<div class="col-sm-'. $cols . $offset .'">';
	}
	
	public static function closeDiv()
	{
		return '</div>';
	}
	
	public static function openGroup()
	{
		return '<div class="form-group">';
	}
	
	/* Form Elements */
	public static function checkbox($name, $value, $options)
	{
		Self::addIdentifier($options, $name);
		
		$return = null;
		$return .= Self::openGroup();
		$return .= Self::error($name);
		$return .= Parent::hidden($name, 0);
		$return .= Self::addParentElement(8, 2);
		$return .= Parent::checkbox($name, $value, null, $options);
		$label = array_pull($options, 'label');
		$return .= '<label class="control-label" for="'. $name .'" style="font-weight: normal;">'.($label ?: null).'</label>';
		$return .= Self::closeDiv();
		$return .= Self::closeDiv();
		$return .= Self::scriptIcheck($options['id']);
		
		return $return;
	}
	
	public static function editor($name, $options = null)
	{
		Self::addClass($options);
		Self::addIdentifier($options, $name);
		
		$return = Self::textarea($name, $options);
		$return .= Self::scriptJodit($options['id'], $options);
		
		return $return;
	}
	
	public static function email($name, $options = null)
	{
		Self::addClass($options);
		Self::addIdentifier($options, $name);
		
		$return = null;
		$return .= Self::openGroup();
		$return .= Self::error($name);
		$return .= Self::label($options, $name);
		$return .= Self::addParentElement();
		$return .= Parent::email($name, null, $options);
		$return .= Self::closeDiv();
		$return .= Self::closeDiv();
		
		return $return;
	}

	public static function error($name)
	{
		$return = null;
		$errors = resolve(ValidationErrors::class);
		if($errors->has($name)) {
			$return .= '
				<p class="alert alert-danger">
					'.$errors->first($name).'
					<a class="close">x</a>
				</p>
				';
		}
		
		return $return;
	}
	
	public static function file($name, $options = null, $fileOptions = null)
	{
		Self::addClass($options);
		
		$return = null;
		$return .= Self::openGroup();
		$return .= Self::error($name);
		$return .= Self::label($options, $name);
		$return .= Self::addParentElement();
		$return .= Parent::file($name, null, $options);
		$return .= '<input type="hidden" id="remove_' . $name . '" name="remove_' . $name . '" value="0">';
		$return .= Self::closeDiv();
		$return .= Self::closeDiv();
		$return .= Self::scriptFileinput($name, $options['placeholder'], $fileOptions);
		
		return $return;
	}
	
	public static function label(&$options, $name, $cols = 2)
	{
		$label = array_pull($options, 'label');
		
		return '<label class="control-label col-sm-'. $cols .'" for="'. $name .'">'.($label ? $label . ':' : null).'</label>';
	}

	public static function model($model, $options = null)
	{
		$options['method'] = 'put';
		$return = null;
		$return .= Parent::model($model, $options);
		$return .= Parent::hidden('id', $model->id);
		
		return $return;
	}
	
	public static function multipleCheckbox($name, $values, $options)
	{
		Self::addIdentifier($options, $name);
		
		$return = null;
		
		$return .= Self::openGroup();
		$return .= Self::error($name);
		$return .= Self::label($options, $name);
		$return .= Self::addParentElement();
		foreach($values as $value => $label) {
			$return .= '<label class="checkbox-inline">';
			$return .= Parent::checkbox($name . '[]', $value, null, $options);
			$return .= $label;
			$return .= '</label>';
		}
		$return .= Self::closeDiv();
		$return .= Self::closeDiv();
		$return .= Self::scriptIcheck($options['id']);
		
		return $return;
	}
	
	public static function number($name, $options = null)
	{
		Self::addClass($options);
		Self::addIdentifier($options, $name);
		
		$return = null;
		$return .= Self::openGroup();
		$return .= Self::error($name);
		$return .= Self::label($options, $name);
		$return .= Self::addParentElement();
		$return .= Parent::number($name, null, $options);
		$return .= Self::closeDiv();
		$return .= Self::closeDiv();
		
		return $return;
	}
	
	public static function password($name, $options = null)
	{
		Self::addClass($options);
		Self::addIdentifier($options, $name);
		
		$return = null;
		$return .= Self::openGroup();
		$return .= Self::error($name);
		$return .= Self::label($options, $name);
		$return .= Self::addParentElement();
		$return .= Parent::password($name, $options);
		$return .= Self::closeDiv();
		$return .= Self::closeDiv();
		
		return $return;
	}
	
	public static function select($name, $selectOptions, $options = null)
	{
		Self::addClass($options);
		Self::addIdentifier($options, $name);
		
		$return = null;
		$return .= Self::openGroup();
		$return .= Self::error($name);
		$return .= Self::label($options, $name);
		$return .= Self::addParentElement();
		$return .= Parent::select((isset($options['multiple']) ? $name . '[]' : $name), $selectOptions, null, $options);
		$return .= Self::closeDiv();
		$return .= Self::closeDiv();
		
		return $return;
	}
	
	public static function select2($name, $selectOptions, $options = null)
	{
		$options['multiple'] = 'multiple';
		$placeholder = array_pull($options, 'placeholder');
		
		$return = Self::select($name, $selectOptions, $options);
		$return .= Self::scriptSelect2($name, $placeholder);
		
		return $return;
	}
	
	public static function switcher($name, $value, $options, $labels)
	{
		Self::addIdentifier($options, $name);
		
		$return = null;
		$return .= Self::openGroup();
		$return .= Self::error($name);
		$return .= Parent::hidden($name, 0);
		$return .= Self::label($options, $name);
		$return .= Self::addParentElement();
		$return .= Parent::checkbox($name, $value, null, $options);
		$return .= Self::closeDiv();
		$return .= Self::scriptSwitcher($name, $labels);
		$return .= Self::closeDiv();
		
		return $return;
	}

	public static function text($name, $options = null, $mask = null)
	{
		Self::addClass($options);
		Self::addIdentifier($options, $name);
		
		$return = null;
		$return .= Self::openGroup();
		$return .= Self::error($name);
		$return .= Self::label($options, $name);
		$return .= Self::addParentElement();
		$return .= Parent::text($name, null, $options);
		$return .= Self::closeDiv();
		$return .= Self::closeDiv();
		
		if($mask) $return .= Self::scriptMaskit($options['id'], $mask);
		
		return $return;
	}
	
	public static function textarea($name, $options = null)
	{
		Self::addClass($options);
		Self::addIdentifier($options, $name);
		
		$return = null;
		$return .= Self::openGroup();
		$return .= Self::error($name);
		$return .= Self::label($options, $name);
		$return .= Self::addParentElement();
		$return .= Parent::textarea($name, null, $options);
		$return .= Self::closeDiv();
		$return .= Self::closeDiv();
		
		return $return;
	}
	
	public static function submit($value, $options = null)
	{
		Self::addClass($options, 'btn');
		
		$return = null;
		$return .= Self::openGroup();
		$return .= Self::addParentElement(8, 2);
		$return .= Parent::submit($value, $options);
		$return .= Self::closeDiv();
		$return .= Self::closeDiv();
		
		return $return;
	}
	
	/* Scripts */
	public static function scriptFileinput($name, $placeholder, $options)
	{
		$fileinput_options = [];
		
		if(isset($placeholder)) $fileinput_options[] = "browseLabel: '". $placeholder ."'";
		if(isset($options['initialPreview'])) $fileinput_options[] = "initialPreview: ['<img src=\"". $options['initialPreview'] ."\" class=\"file-preview-image\">']";
		if(isset($options['allowedFileExtensions'])) $fileinput_options[] = "allowedFileExtensions: ". json_encode($options['allowedFileExtensions']) ;
		if(isset($options['minImageWidth'])) $fileinput_options[] = "minImageWidth: ". $options['minImageWidth'];
		if(isset($options['minImageHeight'])) $fileinput_options[] = "minImageHeight: ". $options['minImageHeight'];
		if(isset($options['maxFileSize'])) $fileinput_options[] = "maxFileSize: ". $options['maxFileSize'];
		
		$fileinput_options = implode(',', $fileinput_options);
		
		return
		'<script>
			$("input[name='. $name .'][type=file]").fileinput({
				language: "pt-BR",
				showUpload: false,
				showCaption: false,
				browseIcon: "<i class=\"glyphicon glyphicon-picturea\"></i>",
				removeClass: "btn btn-danger",
				removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i>",
				overwriteInitial: true,
				' . $fileinput_options . '
			});
			$("input[name='. $name .'][type=file]").on("filecleared", function(event){
				$("#remove_'. $name .'").val(1);
			});
			$("input[name='. $name .'][type=file]").on("fileimageloaded", function(event){
				$("#remove_'. $name .'").val(0);
			});
		</script>';
	}
	
	public static function scriptIcheck($id)
	{
		return '
		<script>
			$("input[id='. $id .']").iCheck({
				checkboxClass: "icheckbox_flat-blue"
			});
		</script>';
	}
	
	public static function scriptJodit($id, $options = [])
	{
		$jodit_options = [];
		
		if(isset($options['height'])) $jodit_options[] = "height: '". $options['height'] ."'";
		if(isset($options['placeholder'])) $jodit_options[] = "placeholder: '". $options['placeholder'] ."'";
		
		$jodit_options = implode(',', $jodit_options);
	
		return '
		<script>
			var editor = new Jodit("#'. $id .'", {'. $jodit_options .'});
		</script>';
	}
	
	public static function scriptMaskit($id, $mask)
	{
		return
		'<script>
			document.querySelector("#'. $id .'").MaskIt("'. $mask .'");
		</script>';
	}
	
	public static function scriptSelect2($id, $placeholder)
	{
		return 
		'<script>
			$("select[id='. $id .']").select2({
				placeholder: "'. $placeholder .'"
			});
		</script>';
	}
	
	public static function scriptSwitcher($name, $labels)
	{
		return '
		<script>
			$("input[name='. $name .'][type=checkbox]").bootstrapSwitch({
				onText: "'. $labels[0] .'",
				offText: "'. $labels[1] .'"
			});
		</script>';
	}
}