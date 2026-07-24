<?php 

namespace App\Classes;

class FaqSchemaGeneratorClass {

    public function get_data($questions, $answers)
    {
        try {

            // Begin creating the schema
            $faqSchema = [
                "@context" => "https://schema.org",
                "@type" => "FAQPage",
                "mainEntity" => [],
            ];

            // Loop through questions and answers and add to the schema
            foreach ($questions as $key => $question) {
                if (isset($answers[$key])) {
                    $faqSchema["mainEntity"][] = [
                        "@type" => "Question",
                        "name" => $question,
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            "text" => $answers[$key],
                        ],
                    ];
                }
            }

            // Convert array to JSON string
            $faqSchemaJson = json_encode($faqSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            return $faqSchemaJson;

        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', __($e->getMessage()));
            return;
        }
    }

}