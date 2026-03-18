@extends('layouts.app')

@section('content')
    <div class="mb-6">

        <h1 class="text-3xl font-bold">
            JSON Formatter & Validator
        </h1>

        <p class="text-gray-600 mt-2">
            Format, validate, and view JSON in a readable structure instantly.
        </p>

    </div>

    <div class="bg-white border rounded-lg p-6 shadow-sm">

        <div class="grid md:grid-cols-2 gap-6">

            <textarea id="jsonInput" class="w-full h-96 border rounded p-3" placeholder="Paste JSON here"></textarea>

            <div>

                <div class="flex gap-2 mb-2">

                    <button onclick="showFormatted()" class="bg-blue-600 text-white px-3 py-1 rounded">
                        Formatted
                    </button>

                    <button onclick="showTree()" class="bg-gray-700 text-white px-3 py-1 rounded">
                        Tree
                    </button>

                </div>


                <textarea id="jsonOutput" class="w-full h-96 border rounded p-3" placeholder="Formatted JSON will appear here..."
                    readonly></textarea>

                <div id="jsonTree" class="h-96 border rounded hidden"></div>

            </div>

        </div>

        <div class="flex flex-wrap gap-3 mt-4">

            <button onclick="formatJSON()" class="bg-blue-600 text-white px-4 py-2 rounded">
                Format
            </button>

            <button onclick="minifyJSON()" class="bg-gray-700 text-white px-4 py-2 rounded">
                Minify
            </button>

            <button onclick="validateJSON()" class="bg-green-600 text-white px-4 py-2 rounded">
                Validate
            </button>

            <button onclick="clearJSON()" class="bg-red-500 text-white px-4 py-2 rounded">
                Clear
            </button>

            <button onclick="copyJSON()" class="bg-indigo-600 text-white px-4 py-2 rounded">
                Copy
            </button>

            <button onclick="downloadJSON()" class="bg-purple-600 text-white px-4 py-2 rounded">
                Download
            </button>

            <label class="bg-gray-800 text-white px-4 py-2 rounded cursor-pointer">
                Upload
                <input type="file" id="jsonFile" class="hidden" onchange="uploadJSON(event)">
            </label>

        </div>

    </div>


    <div class="mt-12">

        <h2 class="text-2xl font-semibold mb-6">
            Frequently Asked Questions
        </h2>

        <div class="space-y-6">

            <div>

                <h3 class="font-semibold text-lg">
                    What is a JSON formatter?
                </h3>

                <p class="text-gray-600 mt-1">
                    A JSON formatter converts raw JSON into a readable structure with proper indentation.
                </p>

            </div>

            <div>

                <h3 class="font-semibold text-lg">
                    How do I validate JSON?
                </h3>

                <p class="text-gray-600 mt-1">
                    Paste JSON into the input box and click validate. The tool will show whether the JSON is valid or
                    contains errors.
                </p>

            </div>

            <div>

                <h3 class="font-semibold text-lg">
                    What does JSON minify mean?
                </h3>

                <p class="text-gray-600 mt-1">
                    Minifying JSON removes spaces and line breaks, making the data smaller and faster to transmit.
                </p>

            </div>

        </div>

    </div>


    <link href="https://cdn.jsdelivr.net/npm/jsoneditor@9/dist/jsoneditor.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jsoneditor@9/dist/jsoneditor.min.js"></script>


    <script>
        let editor;

        function formatJSON() {

            const input = document.getElementById("jsonInput").value;

            try {

                const parsed = JSON.parse(input);

                const formatted = JSON.stringify(parsed, null, 2);

                document.getElementById("jsonOutput").value = formatted;

            } catch (e) {

                alert("Invalid JSON: " + e.message);

            }

        }


        function minifyJSON() {

            const input = document.getElementById("jsonInput").value;

            try {

                const parsed = JSON.parse(input);

                const minified = JSON.stringify(parsed);

                document.getElementById("jsonOutput").value = minified;

            } catch (e) {

                alert("Invalid JSON");

            }

        }


        function validateJSON() {

            const input = document.getElementById("jsonInput").value;

            try {

                JSON.parse(input);

                alert("Valid JSON");

            } catch (e) {

                alert("Invalid JSON: " + e.message);

            }

        }


        function clearJSON() {

            document.getElementById("jsonInput").value = "";
            document.getElementById("jsonOutput").value = "";

        }


        function showFormatted() {

            document.getElementById("jsonOutput").classList.remove("hidden");
            document.getElementById("jsonTree").classList.add("hidden");

        }


        function showTree() {

            const input = document.getElementById("jsonInput").value;

            try {

                const parsed = JSON.parse(input);

                document.getElementById("jsonOutput").classList.add("hidden");
                document.getElementById("jsonTree").classList.remove("hidden");

                if (!editor) {

                    const container = document.getElementById("jsonTree");

                    editor = new JSONEditor(container, {
                        mode: "view"
                    });

                }

                editor.set(parsed);

            } catch (e) {

                alert("Invalid JSON");

            }

        }

        function copyJSON() {

            const output = document.getElementById("jsonOutput").value;

            navigator.clipboard.writeText(output);

            alert("Copied to clipboard");

        }

        function uploadJSON(event) {

            const file = event.target.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function(e) {

                document.getElementById("jsonInput").value = e.target.result;

            };

            reader.readAsText(file);

        }

        function downloadJSON() {

            const data = document.getElementById("jsonOutput").value;

            if (!data) {

                alert("Nothing to download");

                return;

            }

            const blob = new Blob([data], {
                type: "application/json"
            });

            const url = URL.createObjectURL(blob);

            const a = document.createElement("a");

            a.href = url;

            a.download = "formatted.json";

            a.click();

            URL.revokeObjectURL(url);

        }
    </script>
    @verbatim
        <script type="application/ld+json">
{
 "@context": "https://schema.org",
 "@type": "FAQPage",
 "mainEntity": [
   {
     "@type": "Question",
     "name": "What is a JSON formatter?",
     "acceptedAnswer": {
       "@type": "Answer",
       "text": "A JSON formatter converts raw JSON data into a readable structure with indentation."
     }
   },
   {
     "@type": "Question",
     "name": "How do I validate JSON?",
     "acceptedAnswer": {
       "@type": "Answer",
       "text": "Paste JSON into the input field and click validate to check its structure."
     }
   }
 ]
}
</script>
    @endverbatim
@endsection
