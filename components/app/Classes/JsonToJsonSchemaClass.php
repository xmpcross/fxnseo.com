<?php 

namespace App\Classes;

class JsonToJsonSchemaClass {

    public function get_data($json)
    {
        try {
            $parsedJson = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                session()->flash('status', 'error');
                session()->flash('message', __('Invalid JSON provided'));
                return;
            }

            $schema = $this->generateSchema($parsedJson);

            $data = json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return $data;

        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', __($e->getMessage()));
            return;
        }
    }

    /**
     * -------------------------------------------------------------------------------
     *  generateSchema
     * -------------------------------------------------------------------------------
    **/
    private function generateSchema($data, $isRoot = true) 
    {
        $type = gettype($data);

        if ($type === 'double' || $type === 'integer') {
            $type = 'number';
        } elseif ($type === 'array' && $this->isAssociativeArray($data)) {
            $type = 'object';
        }

        $schema = [];

        // If it's the root of the schema, add $schema and title properties first
        if ($isRoot) {
            $schema['$schema'] = "http://json-schema.org/draft-07/schema#";
            $schema['title'] = __('Generated schema for Root');
        }

        $schema['type'] = $type;

        if ($type === 'object') {
            $schema['properties'] = [];
            $schema['required'] = [];
            foreach ($data as $key => $value) {
                $schema['properties'][$key] = $this->generateSchema($value, false);
                $schema['required'][] = $key;
            }
        } 
        elseif ($type === 'array' && !empty($data)) {
            $schema['items'] = $this->generateSchema($data[0], false);
        }

        return $schema;
    }

    /**
     * -------------------------------------------------------------------------------
     *  isAssociativeArray
     * -------------------------------------------------------------------------------
    **/
    private function isAssociativeArray(array $array)
    {
        if ([] === $array) return false;
        return array_keys($array) !== range(0, count($array) - 1);
    }
}