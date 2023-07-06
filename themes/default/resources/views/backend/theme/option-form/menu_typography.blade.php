@php
   $fonts = getAllFonts();
@endphp
{{-- Menu Typography --}}
<h3 class="black mb-3">{{ translate('Menu Typography') }}</h3>
<input type="hidden" name="option_name" value="menu_typography">

{{-- Menu Typography Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-3">
        <label for="" class="font-16 bold black">{{ translate('Menu Typography') }}
        </label>
        <span class="d-block">{{ translate('These settings control the typography for menu.') }}</span>
    </div>
    <div class="col-xl-8 offset-xl-1">
        <input type="hidden" name="menu_typography_google_link_s" id="menu_typography_google_link_s" value="{{ isset($option_settings['menu_typography_google_link_s']) ? $option_settings['menu_typography_google_link_s']:''}}">

        <input type="hidden" name="menu_typography_css_i" id="menu_typography_css" value="{{ isset($option_settings['menu_typography_css_i']) ? $option_settings['menu_typography_css_i']:''}}">

        <input type="hidden" name="menu_font_unit_i" value="px">
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>{{ translate('Font Family') }}</label>
                    <select name="menu_font_font-family" class="form-control select font_family" id="menu_font_family" data-section="menu">
                        <option value="" {{ isset($option_settings['menu_font_font-family']) ? '':'selected' }}>{{ translate('Select  Fonts') }}</option>
                        <optgroup label="{{ translate('Custom Fonts') }}">
                            <option value="custom-font-1,sans-serif" {{ isset($option_settings['menu_font_font-family']) && $option_settings['menu_font_font-family'] == 'custom-font-1,sans-serif' ? 'selected':'' }}  data-subsets="" data-variations="">{{ translate('Custom Font 1') }}</option>

                            <option value="custom-font-2,sans-serif" {{ isset($option_settings['menu_font_font-family']) && $option_settings['menu_font_font-family'] == 'custom-font-2,sans-serif' ? 'selected':'' }}  data-subsets="" data-variations="">{{ translate('Custom Font 2') }}</option>
                        </optgroup>
                        <optgroup label="{{ translate('Google Web Fonts') }}">
                            @foreach ($fonts as $font)
                                <option value="{{ $font['family'].',sans-serif' }}"
                                    {{ isset($option_settings['menu_font_font-family']) && $option_settings['menu_font_font-family'] == $font['family'].',sans-serif' ? 'selected':'' }} 
                                    data-subsets="{{ $font['subsets'] }}" data-variations="{{ $font['variants'] }}">
                                    {{ $font['family'] }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>{{ translate('Font Weight & Style') }}</label>
                    <input type="hidden" name="menu_font_font-style" id="menu_font_style" value="{{ isset($option_settings['menu_font_font-style']) ? $option_settings['menu_font_font-style']:'' }}">

                    <input type="hidden" name="menu_font_font-weight" id="menu_font_weight" value="{{ isset($option_settings['menu_font_font-weight']) ? $option_settings['menu_font_font-weight']:'' }}">

                    <select name="menu_font_weight_style_i" class="form-control select" id="menu_font_weight_style_i" data-value="{{ isset($option_settings['menu_font_weight_style_i']) ? $option_settings['menu_font_weight_style_i']:null }}" onchange="createUrl('menu')">
                        <option value="" {{ isset($option_settings['menu_font_weight_style_i']) ? '':'selected' }}>{{ translate('Select Weight & Style') }}</option>
                        <option value="400" {{ isset($option_settings['menu_font_weight_style_i']) && $option_settings['menu_font_weight_style_i'] == '400' ? 'selected':'' }}>Normal 400</option>
                        <option value="700" {{ isset($option_settings['menu_font_weight_style_i']) && $option_settings['menu_font_weight_style_i'] == '700' ? 'selected':'' }}>Bold 700</option>
                        <option value="400italic" {{ isset($option_settings['menu_font_weight_style_i']) && $option_settings['menu_font_weight_style_i'] == '400italic' ? 'selected':'' }}>Normal 400 Italic</option>
                        <option value="700italic" {{ isset($option_settings['menu_font_weight_style_i']) && $option_settings['menu_font_weight_style_i'] == '700italic' ? 'selected':'' }}>Bold 700 Italic</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>{{ translate('Font Subsets') }}</label>
                    <select name="menu_font_font-subsets_i" class="form-control select" id="menu_font_subsets" data-value="{{ isset($option_settings['menu_font_font-subsets_i']) ? $option_settings['menu_font_font-subsets_i']:null }}"  onchange="createUrl('menu')">
                        <option value="" {{ isset($option_settings['menu_font_font-subsets_i']) ? '':'selected' }}>{{ translate('Select Font Subsets') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>{{ translate('Text Align') }}</label>
                    <select name="menu_font_text-align" class="form-control select" id="menu_text_align" onchange="createFontCss('menu')">
                        <option value="" disabled {{ isset($option_settings['menu_font_text-align']) ? '':'selected' }}>{{ translate('Text Align') }}</option>
                        <option value="inherit" {{ isset($option_settings['menu_font_text-align']) && $option_settings['menu_font_text-align'] == 'inherit' ? 'selected':'' }}>Inherit</option>
                        <option value="left" {{ isset($option_settings['menu_font_text-align']) && $option_settings['menu_font_text-align'] == 'left' ? 'selected':'' }}>Left</option>
                        <option value="right" {{ isset($option_settings['menu_font_text-align']) && $option_settings['menu_font_text-align'] == 'right' ? 'selected':'' }}>Right</option>
                        <option value="center" {{ isset($option_settings['menu_font_text-align']) && $option_settings['menu_font_text-align'] == 'center' ? 'selected':'' }}>Center</option>
                        <option value="justify" {{ isset($option_settings['menu_font_text-align']) && $option_settings['menu_font_text-align'] == 'justify' ? 'selected':'' }}>Justify</option>
                        <option value="initial" {{ isset($option_settings['menu_font_text-align']) && $option_settings['menu_font_text-align'] == 'initial' ? 'selected':'' }}>Initial</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>{{ translate('Text Transform') }}</label>
                    <select name="menu_font_text-transform" class="form-control select" id="menu_text_transform" onchange="createFontCss('menu')">
                        <option value="" disabled {{ isset($option_settings['menu_font_text-transform']) ? '':'selected' }}>{{ translate('Text Transform') }}</option>
                        <option value="none" {{ isset($option_settings['menu_font_text-transform']) && $option_settings['menu_font_text-transform'] == 'none' ? 'selected':'' }}>None</option>
                        <option value="capitalize" {{ isset($option_settings['menu_font_text-transform']) && $option_settings['menu_font_text-transform'] == 'capitalize' ? 'selected':'' }}>Capitalize</option>
                        <option value="uppercase" {{ isset($option_settings['menu_font_text-transform']) && $option_settings['menu_font_text-transform'] == 'uppercase' ? 'selected':'' }}>Uppercase</option>
                        <option value="lowercase" {{ isset($option_settings['menu_font_text-transform']) && $option_settings['menu_font_text-transform'] == 'lowercase' ? 'selected':'' }}>Lowercase</option>
                        <option value="initial" {{ isset($option_settings['menu_font_text-transform']) && $option_settings['menu_font_text-transform'] == 'initial' ? 'selected':'' }}>Initial</option>
                        <option value="inherit" {{ isset($option_settings['menu_font_text-transform']) && $option_settings['menu_font_text-transform'] == 'inherit' ? 'selected':'' }}>Inherit</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-6 row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>{{ translate('Font Size') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="menu_font_u_font-size"
                                id="menu_font_size" placeholder="{{ translate('Size') }}" value="{{ isset($option_settings['menu_font_u_font-size']) ? $option_settings['menu_font_u_font-size']:'' }}" onkeyup="createFontCss('menu')">
                            <div class="input-group-append">
                                <div class="input-group-text">px</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>{{ translate('Line Height') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="menu_font_u_line-height"
                                id="menu_line_height" placeholder="{{ translate('Height') }}" value="{{ isset($option_settings['menu_font_u_line-height']) ? $option_settings['menu_font_u_line-height']:'' }}" onkeyup="createFontCss('menu')">
                            <div class="input-group-append">
                                <div class="input-group-text">px</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 row">
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>{{ translate('Word Spacing') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="menu_font_u_word-spacing"
                                id="menu_word_spacing" placeholder="{{ translate('Word Spacing') }}" value="{{ isset($option_settings['menu_font_u_word-spacing']) ? $option_settings['menu_font_u_word-spacing']:'' }}" onkeyup="createFontCss('menu')">
                            <div class="input-group-append">
                                <div class="input-group-text">px</div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>{{ translate('Letter Spacing') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="menu_font_u_letter-spacing"
                                id="menu_letter_spacing" placeholder="{{ translate('Letter Spacing') }}" value="{{ isset($option_settings['menu_font_u_letter-spacing']) ? $option_settings['menu_font_u_letter-spacing']:'' }}" onkeyup="createFontCss('menu')">
                            <div class="input-group-append">
                                <div class="input-group-text">px</div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-xl-4">
                    <label for="menu_font_color">{{ translate('Select Color') }}</label>
                    <div class="color w-100">
                        <input type="text" class="form-control" name="menu_font_color"
                            value="{{ isset($option_settings['menu_font_color']) ? $option_settings['menu_font_color']:'' }}">
                        <input type="color" class="" id="menu_font_color" value="{{ isset($option_settings['menu_font_color']) ? $option_settings['menu_font_color']:'#fafafa' }}" oninput="createFontCss('menu')">
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 border p-4 typography_preview" id="menu_typography_preview">
            {{ translate('The Quick Brown Fox Jumps Over The Lazy Dog') }}
        </div>
    </div>
</div>
{{-- Menu Typography Field End --}}


{{-- Sub Menu Typography Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-3">
        <label for="" class="font-16 bold black">{{ translate('Submenu Typography') }}
        </label>
        <span class="d-block">{{ translate('These settings control the typography for submenu.') }}</span>
    </div>
    <div class="col-xl-8 offset-xl-1">
        <input type="hidden" name="sub_menu_typography_google_link_s" id="sub_menu_typography_google_link_s" value="{{ isset($option_settings['sub_menu_typography_google_link_s']) ? $option_settings['sub_menu_typography_google_link_s']:''}}">

        <input type="hidden" name="sub_menu_typography_css_i" id="sub_menu_typography_css" value="{{ isset($option_settings['sub_menu_typography_css_i']) ? $option_settings['sub_menu_typography_css_i']:''}}">

        <input type="hidden" name="sub_menu_font_unit_i" value="px">
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>{{ translate('Font Family') }}</label>
                    <select name="sub_menu_font_font-family" class="form-control select font_family" id="sub_menu_font_family" data-section="sub_menu">
                        <option value="" {{ isset($option_settings['sub_menu_font_font-family']) ? '':'selected' }}>{{ translate('Select  Fonts') }}</option>
                        <optgroup label="{{ translate('Custom Fonts') }}">
                            <option value="custom-font-1,sans-serif" {{ isset($option_settings['sub_menu_font_font-family']) && $option_settings['sub_menu_font_font-family'] == 'custom-font-1,sans-serif' ? 'selected':'' }} data-subsets="" data-variations="">{{ translate('Custom Font 1') }}</option>
                            <option value="custom-font-2,sans-serif" {{ isset($option_settings['sub_menu_font_font-family']) && $option_settings['sub_menu_font_font-family'] == 'custom-font-2,sans-serif' ? 'selected':'' }} data-subsets="" data-variations="">{{ translate('Custom Font 2') }}</option>
                        </optgroup>
                        <optgroup label="{{ translate('Google Web Fonts') }}">
                            @foreach ($fonts as $font)
                                <option value="{{ $font['family'].',sans-serif' }}"
                                    {{ isset($option_settings['sub_menu_font_font-family']) && $option_settings['sub_menu_font_font-family'] == $font['family'].',sans-serif' ? 'selected':'' }} 
                                    data-subsets="{{ $font['subsets'] }}" data-variations="{{ $font['variants'] }}">
                                    {{ $font['family'] }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>{{ translate('Font Weight & Style') }}</label>
                    <input type="hidden" name="sub_menu_font_font-style" id="sub_menu_font_style" value="{{ isset($option_settings['sub_menu_font_font-style']) ? $option_settings['sub_menu_font_font-style']:'' }}">

                    <input type="hidden" name="sub_menu_font_font-weight" id="sub_menu_font_weight" value="{{ isset($option_settings['sub_menu_font_font-weight']) ? $option_settings['sub_menu_font_font-weight']:'' }}">

                    <select name="sub_menu_font_weight_style_i" class="form-control select" id="sub_menu_font_weight_style_i" data-value="{{ isset($option_settings['sub_menu_font_weight_style_i']) ? $option_settings['sub_menu_font_weight_style_i']:null }}" onchange="createUrl('sub_menu')">
                        <option value="" {{ isset($option_settings['sub_menu_font_weight_style_i']) ? '':'selected' }}>{{ translate('Select Weight & Style') }}</option>
                        <option value="400" {{ isset($option_settings['sub_menu_font_weight_style_i']) && $option_settings['sub_menu_font_weight_style_i'] == '400' ? 'selected':'' }}>Normal 400</option>
                        <option value="700" {{ isset($option_settings['sub_menu_font_weight_style_i']) && $option_settings['sub_menu_font_weight_style_i'] == '700' ? 'selected':'' }}>Bold 700</option>
                        <option value="400italic" {{ isset($option_settings['sub_menu_font_weight_style_i']) && $option_settings['sub_menu_font_weight_style_i'] == '400italic' ? 'selected':'' }}>Normal 400 Italic</option>
                        <option value="700italic" {{ isset($option_settings['sub_menu_font_weight_style_i']) && $option_settings['sub_menu_font_weight_style_i'] == '700italic' ? 'selected':'' }}>Bold 700 Italic</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>{{ translate('Font Subsets') }}</label>
                    <select name="sub_menu_font_subsets_i" class="form-control select" id="sub_menu_font_subsets" data-value="{{ isset($option_settings['sub_menu_font_subsets_i']) ? $option_settings['sub_menu_font_subsets_i']:null }}"  onchange="createUrl('sub_menu')">
                        <option value="" {{ isset($option_settings['sub_menu_font_subsets_i']) ? '':'selected' }}>{{ translate('Select Font Subsets') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>{{ translate('Text Align') }}</label>
                    <select name="sub_menu_font_text-align" class="form-control select" id="sub_menu_text_align" onchange="createFontCss('sub_menu')">
                        <option value="" disabled {{ isset($option_settings['sub_menu_font_text-align']) ? '':'selected' }}>{{ translate('Text Align') }}</option>
                        <option value="inherit" {{ isset($option_settings['sub_menu_font_text-align']) && $option_settings['sub_menu_font_text-align'] == 'inherit' ? 'selected':'' }}>Inherit</option>
                        <option value="left" {{ isset($option_settings['sub_menu_font_text-align']) && $option_settings['sub_menu_font_text-align'] == 'left' ? 'selected':'' }}>Left</option>
                        <option value="right" {{ isset($option_settings['sub_menu_font_text-align']) && $option_settings['sub_menu_font_text-align'] == 'right' ? 'selected':'' }}>Right</option>
                        <option value="center" {{ isset($option_settings['sub_menu_font_text-align']) && $option_settings['sub_menu_font_text-align'] == 'center' ? 'selected':'' }}>Center</option>
                        <option value="justify" {{ isset($option_settings['sub_menu_font_text-align']) && $option_settings['sub_menu_font_text-align'] == 'justify' ? 'selected':'' }}>Justify</option>
                        <option value="initial" {{ isset($option_settings['sub_menu_font_text-align']) && $option_settings['sub_menu_font_text-align'] == 'initial' ? 'selected':'' }}>Initial</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>{{ translate('Text Transform') }}</label>
                    <select name="sub_menu_font_text-transform" class="form-control select" id="sub_menu_text_transform" onchange="createFontCss('sub_menu')">
                        <option value="" disabled {{ isset($option_settings['sub_menu_font_text-transform']) ? '':'selected' }}>{{ translate('Text Transform') }}</option>
                        <option value="none" {{ isset($option_settings['sub_menu_font_text-transform']) && $option_settings['sub_menu_font_text-transform'] == 'none' ? 'selected':'' }}>None</option>
                        <option value="capitalize" {{ isset($option_settings['sub_menu_font_text-transform']) && $option_settings['sub_menu_font_text-transform'] == 'capitalize' ? 'selected':'' }}>Capitalize</option>
                        <option value="uppercase" {{ isset($option_settings['sub_menu_font_text-transform']) && $option_settings['sub_menu_font_text-transform'] == 'uppercase' ? 'selected':'' }}>Uppercase</option>
                        <option value="lowercase" {{ isset($option_settings['sub_menu_font_text-transform']) && $option_settings['sub_menu_font_text-transform'] == 'lowercase' ? 'selected':'' }}>Lowercase</option>
                        <option value="initial" {{ isset($option_settings['sub_menu_font_text-transform']) && $option_settings['sub_menu_font_text-transform'] == 'initial' ? 'selected':'' }}>Initial</option>
                        <option value="inherit" {{ isset($option_settings['sub_menu_font_text-transform']) && $option_settings['sub_menu_font_text-transform'] == 'inherit' ? 'selected':'' }}>Inherit</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-6 row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>{{ translate('Font Size') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="sub_menu_font_u_font-size"
                                id="sub_menu_font_size" placeholder="{{ translate('Size') }}" value="{{ isset($option_settings['sub_menu_font_u_font-size']) ? $option_settings['sub_menu_font_u_font-size']:'' }}" onkeyup="createFontCss('sub_menu')">
                            <div class="input-group-append">
                                <div class="input-group-text">px</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>{{ translate('Line Height') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="sub_menu_font_u_line-height"
                                id="sub_menu_line_height" placeholder="{{ translate('Height') }}" value="{{ isset($option_settings['sub_menu_font_u_line-height']) ? $option_settings['sub_menu_font_u_line-height']:'' }}" onkeyup="createFontCss('sub_menu')">
                            <div class="input-group-append">
                                <div class="input-group-text">px</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 row">
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>{{ translate('Word Spacing') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="sub_menu_font_u_word-spacing"
                                id="sub_menu_word_spacing" placeholder="{{ translate('Word Spacing') }}" value="{{ isset($option_settings['sub_menu_font_u_word-spacing']) ? $option_settings['sub_menu_font_u_word-spacing']:'' }}" onkeyup="createFontCss('sub_menu')">
                            <div class="input-group-append">
                                <div class="input-group-text">px</div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>{{ translate('Letter Spacing') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="sub_menu_font_u_letter-spacing"
                                id="sub_menu_letter_spacing" placeholder="{{ translate('Letter Spacing') }}" value="{{ isset($option_settings['sub_menu_font_u_letter-spacing']) ? $option_settings['sub_menu_font_u_letter-spacing']:'' }}" onkeyup="createFontCss('sub_menu')">
                            <div class="input-group-append">
                                <div class="input-group-text">px</div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-xl-4">
                    <label for="sub_menu_font_color">{{ translate('Select Color') }}</label>
                    <div class="color w-100">
                        <input type="text" class="form-control" name="sub_menu_font_color"
                            value="{{ isset($option_settings['sub_menu_font_color']) ? $option_settings['sub_menu_font_color']:'' }}">
                        <input type="color" class="" id="sub_menu_font_color" value="{{ isset($option_settings['sub_menu_font_color']) ? $option_settings['sub_menu_font_color']:'#fafafa' }}" oninput="createFontCss('sub_menu')">
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 border p-4 typography_preview" id="sub_menu_typography_preview">
            {{ translate('The Quick Brown Fox Jumps Over The Lazy Dog') }}
        </div>
    </div>
</div>
{{-- Sub Menu Typography Field End --}}