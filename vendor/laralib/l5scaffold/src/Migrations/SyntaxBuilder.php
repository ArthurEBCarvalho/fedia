<?php

namespace Laralib\L5scaffold\Migrations;

use Laralib\L5scaffold\GeneratorException;


/**
 * Class SyntaxBuilder with modifications by Fernando
 * @package Laralib\L5scaffold\Migrations
 * @author Jeffrey Way <jeffrey@jeffrey-way.com>
 */
class SyntaxBuilder
{

    /**
     * A template to be inserted.
     *
     * @var string
     */
    private $template;

    /**
     * @var bool
     */
    protected $illuminate = false;

    /**
     * Enable/Disable use of Illuminate/Html form facades
     *
     * @param $value
     */
    public function setIllumination($value) {
        $this->illuminate = $value;
    }

    /**
     * Create the PHP syntax for the given schema.
     *
     * @param  array $schema
     * @param  array $meta
     * @param  string $type
     * @param  bool $illuminate
     * @return string
     * @throws GeneratorException
     * @throws \Exception
     */
    public function create($schema, $meta, $type = "migration", $illuminate = false)
    {
        $this->setIllumination($illuminate);

        if ($type == "migration") {

            $up = $this->createSchemaForUpMethod($schema, $meta);
            $down = $this->createSchemaForDownMethod($schema, $meta);
            return compact('up', 'down');


        } else if ($type == "controller") {

            $fieldsc = $this->createSchemaForControllerMethod($schema, $meta);
            return $fieldsc;


        } else if ($type == "view-index-header") {

            $fieldsc = $this->createSchemaForViewMethod($schema, $meta, 'index-header');
            return $fieldsc;

        } else if ($type == "view-index-content") {

            $fieldsc = $this->createSchemaForViewMethod($schema, $meta, 'index-content');
            return $fieldsc;

        } else if ($type == "view-index-search") {

            $fieldsc = $this->createSchemaForViewMethod($schema, $meta, 'index-search');
            return $fieldsc;

        } else if ($type == "view-form-content") {

            $fieldsc = $this->createSchemaForViewMethod($schema, $meta, 'form-content');
            return $fieldsc;

        } else {
            throw new \Exception("Type not found in syntaxBuilder");
        }
    }

    /**
     * Create the schema for the "up" method.
     *
     * @param  string $schema
     * @param  array $meta
     * @return string
     * @throws GeneratorException
     */
    private function createSchemaForUpMethod($schema, $meta)
    {
        //dd($schema);
        $fields = $this->constructSchema($schema);


        if ($meta['action'] == 'create') {
            return $this->insert($fields)->into($this->getCreateSchemaWrapper());
        }

        if ($meta['action'] == 'add') {
            return $this->insert($fields)->into($this->getChangeSchemaWrapper());
        }

        if ($meta['action'] == 'remove') {
            $fields = $this->constructSchema($schema, 'Drop');

            return $this->insert($fields)->into($this->getChangeSchemaWrapper());
        }

        // Otherwise, we have no idea how to proceed.
        throw new GeneratorException;
    }


    /**
     * Construct the syntax for a down field.
     *
     * @param  array $schema
     * @param  array $meta
     * @return string
     * @throws GeneratorException
     */
    private function createSchemaForDownMethod($schema, $meta)
    {
        // If the user created a table, then for the down
        // method, we should drop it.
        if ($meta['action'] == 'create') {
            return sprintf("Schema::drop('%s');", $meta['table']);
        }

        // If the user added columns to a table, then for
        // the down method, we should remove them.
        if ($meta['action'] == 'add') {
            $fields = $this->constructSchema($schema, 'Drop');

            return $this->insert($fields)->into($this->getChangeSchemaWrapper());
        }

        // If the user removed columns from a table, then for
        // the down method, we should add them back on.
        if ($meta['action'] == 'remove') {
            $fields = $this->constructSchema($schema);

            return $this->insert($fields)->into($this->getChangeSchemaWrapper());
        }

        // Otherwise, we have no idea how to proceed.
        throw new GeneratorException;
    }

    /**
     * Store the given template, to be inserted somewhere.
     *
     * @param  string $template
     * @return $this
     */
    private function insert($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get the stored template, and insert into the given wrapper.
     *
     * @param  string $wrapper
     * @param  string $placeholder
     * @return mixed
     */
    private function into($wrapper, $placeholder = 'schema_up')
    {
        return str_replace('{{' . $placeholder . '}}', $this->template, $wrapper);
    }

    /**
     * Get the wrapper template for a "create" action.
     *
     * @return string
     */
    private function getCreateSchemaWrapper()
    {
        return file_get_contents(__DIR__ . '/../stubs/schema-create.stub');
    }

    /**
     * Get the wrapper template for an "add" action.
     *
     * @return string
     */
    private function getChangeSchemaWrapper()
    {
        return file_get_contents(__DIR__ . '/../stubs/schema-change.stub');
    }

    /**
     * Construct the schema fields.
     *
     * @param  array $schema
     * @param  string $direction
     * @return array
     */
    private function constructSchema($schema, $direction = 'Add')
    {
        if (!$schema) return '';

        $fields = array_map(function ($field) use ($direction) {
            $method = "{$direction}Column";
            return $this->$method($field);
        }, $schema);


        return implode("\n" . str_repeat(' ', 12), $fields);
    }


    /**
     * Construct the syntax to add a column.
     *
     * @param  string $field
     * @param string $type
     * @param $meta
     * @return string
     */
    private function addColumn($field, $type = "migration", $meta = "")
    {


        if ($type == 'migration') {

            $syntax = sprintf("\$table->%s('%s')", $field['type'], $field['name']);

            // If there are arguments for the schema type, like decimal('amount', 5, 2)
            // then we have to remember to work those in.
            if ($field['arguments']) {
                $syntax = substr($syntax, 0, -1) . ', ';

                $syntax .= implode(', ', $field['arguments']) . ')';
            }

            foreach ($field['options'] as $method => $value) {
                $syntax .= sprintf("->%s(%s)", $method, $value === true ? '' : $value);
            }

            $syntax .= ';';


        } elseif ($type == 'view-index-header') {

            // Fields to index view
            $syntax = '@if(is_null($param))'."\n";
            $syntax .= '<th><a href="{{Request::fullUrl()}}{{$signal}}order='.strtolower($field['name']).'" class="white-text templatemo-sort-by">'.ucfirst($field['name']).' <span class="fa fa-caret-{{$caret}}"></span></a></th>'."\n";
            $syntax .= '@else'."\n";
            $syntax .= '@if(strpos($param,\'desc\') !== false)'."\n";
            $syntax .= '<th><a href="{{str_replace(str_replace(\' \',\'%20\',$param),\''.strtolower($field['name']).'\',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,\''.strtolower($field['name']).'\') !== false)active @endif">'.ucfirst($field['name']).' <span class="fa fa-caret-{{$caret}}"></span></a></th>'."\n";
            $syntax .= '@else'."\n";
            $syntax .= '<th><a href="{{str_replace(\'order=\'.$param,\'order='.strtolower($field['name']).'\',Request::fullUrl())}} @if($param == \''.strtolower($field['name']).'\')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,\''.strtolower($field['name']).'\') !== false)active @endif">'.ucfirst($field['name']).' <span class="fa fa-caret-{{$caret}}"></span></a></th>'."\n";
            $syntax .= '@endif'."\n";
            $syntax .= '@endif'."\n";

        } elseif ($type == 'view-index-search') {

            // Fields to index view
            $syntax = sprintf('<option value="%s" @if ($filtro == "%s") selected @endif>%s</option>', $field['name'], $field['name'], ucfirst($field['name']));

        } elseif ($type == 'view-index-content') {

            // Fields to index view
            switch($field['type']) {
                case 'date':
                $syntax = sprintf("<td>{{date_format(date_create_from_format('Y-m-d', \$%s->%s), 'd/m/Y')}}</td>", $meta['var_name'], strtolower($field['name']));
                break;
                case 'decimal':
                $syntax = sprintf("<td>{{number_format(\$%s->%s,2,',','.')}}</td>", $meta['var_name'], strtolower($field['name']));
                break;
                default:
                $syntax = sprintf("<td>{{\$%s->%s}}</td>", $meta['var_name'], strtolower($field['name']));
                break;
            }

            // $syntax .= '}}</td>';

        } elseif ($type == 'view-form-content') {
            $syntax = $this->buildField($field, $type, $meta['var_name']);
        } else {
            // Fields to controller
            switch($field['type']) {
                case 'decimal':
                $syntax = sprintf("\$%s->%s = str_replace(\",\", \".\", str_replace(\".\", \"\", \$request->input(\"%s\")));", $meta['var_name'], $field['name'], $field['name']);
                break;
                default:
                $syntax = sprintf("\$%s->%s = \$request->input(\"%s\");", $meta['var_name'], $field['name'], $field['name']);
                break;
            }
        }

        return $syntax;
    }

    /**
     * Build form field with validation using Illuminate/Html Form facade or pure HTML
     *
     * @param $field
     * @param $variable
     * @param bool $value
     * @return string
     */
    private function buildField($field, $type, $variable, $value = true)
    {
        $column = strtolower($field['name']);
        $title = ucfirst($field['name']);

        $syntax = [];

        switch($type) {
            case 'string':
            default:
            $input = 'text';
            break;
            case 'text':
            $input = 'textarea';
            break;
        }

        $syntax[] = '<div class="row form-group">';
        $syntax[] = '<div class="col-md-12">';
        if(array_shift($field['options']) == '1'){
            $syntax[] = "{!! Form::label('$column', '$title', ['class' => 'control-label']) !!}";
            $syntax[] = $this->htmlField($column, $variable, $field, $type, true);
        }
        else{
            $syntax[] = "{!! Html::decode(Form::label('$column', '$title <span class=\"obrigatorio\">*</span>', ['class' => 'control-label'])) !!}";
            $syntax[] = $this->htmlField($column, $variable, $field, $type, false);
        }

        // $syntax[] = '@if($errors->has("' . $column . '"))';
        // $syntax[] = '<span class="help-block">{{ $errors->first("' . $column . '") }}</span>';
        // $syntax[] = '@endif';
        $syntax[] = '</div>';
        $syntax[] = '</div>';

        return join("\n".str_repeat(' ', 20), $syntax);
    }


    /**
     * Construct the syntax to drop a column.
     *
     * @param  string $field
     * @return string
     */
    private function dropColumn($field)
    {
        return sprintf("\$table->dropColumn('%s');", $field['name']);
    }


    /**
     * Construct the controller fields
     *
     * @param $schema
     * @param $meta
     * @return string
     */
    private function createSchemaForControllerMethod($schema, $meta)
    {


        if (!$schema) return '';

        $fields = array_map(function ($field) use ($meta) {
            return $this->AddColumn($field, 'controller', $meta);
        }, $schema);


        return implode("\n" . str_repeat(' ', 8), $fields);
    }


    /**
     * Construct the view fields
     *
     * @param $schema
     * @param $meta
     * @param string $type Params 'header' or 'content'
     * @return string
     */
    private function createSchemaForViewMethod($schema, $meta, $type = 'index-header')
    {


        if (!$schema) return '';

        $fields = array_map(function ($field) use ($meta, $type) {
            return $this->AddColumn($field, 'view-' . $type, $meta);
        }, $schema);


        // Format code
        if ($type == 'index-header') {
            return implode("\n" . str_repeat(' ', 24), $fields);
        } else {
            // index-content
            return implode("\n" . str_repeat(' ', 20), $fields);
        }

    }

    private function htmlField($column, $variable, $field, $type, $nullable)
    {

        if ($nullable)
            $required = "";
        else
            $required = ", 'required' => 'true'";

        switch ($field['type']) {
            case 'string':
            default:
            $layout = "{!! Form::text('$column', $".$variable.'->'.$column.", ['class' => 'form-control',".str_replace(", ","",$required)."]) !!}";
            break;
            case 'date':
            $layout = "{!! Form::date('$column', $".$variable.'->'.$column.", ['class' => 'form-control',".str_replace(", ","",$required)."]) !!}";
            break;
            case 'decimal':
            $layout = "@if(\$method == 'post') {!! Form::text('$column', NULL, ['class' => 'form-control','onKeyDown' => 'Formata(this,20,event,2)'$required]) !!} @else {!! Form::text('$column', number_format($".$variable.'->'.$column.",2,',','.'), ['onKeyDown' => 'Formata(this,20,event,2)'$required]) !!} @endif";
            break;
            case 'boolean':
            $layout = "<div class=\"btn-group\" data-toggle=\"buttons\"><label class=\"btn btn-primary\"><input type=\"radio\" value=\"true\" name=\"$column-field\" id=\"$column-field\" autocomplete=\"off\"> True</label><label class=\"btn btn-primary active\"><input type=\"radio\" name=\"$column-field\" value=\"false\" id=\"$column-field\" autocomplete=\"off\"> False</label></div>";
            break;
            case 'text':
            $layout = "{!! Form::textarea('$column', $".$variable.'->'.$column.", ['class' => 'form-control','rows' => '4'$required]) !!}";
            break;
            case 'integer':
            $layout = "{!! Form::text('$column', $".$variable.'->'.$column.", ['class' => 'form-control','onKeyPress' => 'validar_numero(event)'$required]) !!}";
            break;
        }

        return $layout;
    }

}
