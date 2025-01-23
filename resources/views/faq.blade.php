@extends('layouts.master')
@section('content')
    <div class="about-us-container">
        <div class="row section">
            <div class="column xs12">
                <div class="title">
                    <h1>Frequently Asked Questions</h1>
                </div>
            </div>
            <div class="column">
                <div class="faq-section">
                    @foreach($faq as $item)
                        <div class="faq-item">
                            <div class="faq-question">
                                <span class="faq-question-number"><?=$loop->index+1?>.</span>
                                <span class="faq-question-text">{{$item["question"]}}</span>
                                <div class="faq-arrow">
                                   @svg('/images/icons/caret-down.svg')
                                </div>
                            </div>
                            <div class="faq-answer">
                                <div class="answer-content">
                                        <?=$item["answer"]?>
                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    @include("partials.slider",["main_title"=>"FEATURED"])
    @include("partials.summer")
    @include("partials.blog")
    @include("partials.contact")
    <script>
         document.addEventListener('DOMContentLoaded', () => {
             $(".faq-question").on("click", function (){
                 $(this).toggleClass("active");
                let $target=$(this).parent().find(".faq-answer");
                $target.height($(this).hasClass("active")?$target[0].scrollHeight:0);

             })
         });
    </script>

@endsection
@section("head")
    <?php
    $structuredData=[
        "@context" => "https://schema.org",
        "@type" => "FAQPage",
        "mainEntity" => []
    ];
    foreach ($faq as $item){
        $structuredData["mainEntity"][]=[
            "@type" => "Question",
            "name" => $item["question"],
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => $item["answer"]
            ]
        ];
    }

?>
    <script type="application/ld+json">
        <?=json_encode($structuredData)?>
    </script>
@endsection
