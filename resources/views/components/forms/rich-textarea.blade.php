@props([
    'name',
    'id' => null,
    'value' => '',
    'rows' => 4,
    'placeholder' => '',
    'required' => false,
    'hasError' => false,
])

@php
    $inputId = $id ?? 'rich_' . str_replace(['[', ']'], ['_', ''], $name);
@endphp

<div class="space-y-1.5 w-full" x-data="{
    insertPrefix(prefixType) {
        const textarea = this.$refs.editorTextarea;
        if (!textarea) return;

        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;

        // Find the start of the line containing the selection start
        const lineStart = text.lastIndexOf('\n', start - 1) + 1;
        // Find the end of the line containing the selection end
        let lineEnd = text.indexOf('\n', end);
        if (lineEnd === -1) lineEnd = text.length;

        const selectedLines = text.substring(lineStart, lineEnd).split('\n');

        let modifiedLines = [];
        if (prefixType === 'bullet') {
            // Check if all selected lines already have bullet
            const allHaveBullet = selectedLines.every(l => l.trimStart().startsWith('• '));
            modifiedLines = selectedLines.map(l => {
                if (allHaveBullet) {
                    return l.replace(/^(\s*)•\s?/, '$1');
                } else {
                    return l.replace(/^(\s*)(•\s?|\d+\.\s?)?/, '$1• ');
                }
            });
        } else if (prefixType === 'number') {
            // Check if all lines already have numbers
            const allHaveNumber = selectedLines.every(l => /^\s*\d+\.\s/.test(l));
            let counter = 1;
            modifiedLines = selectedLines.map(l => {
                if (allHaveNumber) {
                    return l.replace(/^(\s*)\d+\.\s?/, '$1');
                } else {
                    return l.replace(/^(\s*)(•\s?|\d+\.\s?)?/, `$1${counter++}. `);
                }
            });
        }

        const newText = text.substring(0, lineStart) + modifiedLines.join('\n') + text.substring(lineEnd);
        textarea.value = newText;

        // Trigger input event for reactive frameworks/forms
        textarea.dispatchEvent(new Event('input', { bubbles: true }));

        // Restore focus
        textarea.focus();
        textarea.setSelectionRange(lineStart, lineStart + modifiedLines.join('\n').length);
    },

    insertBold() {
        const textarea = this.$refs.editorTextarea;
        if (!textarea) return;

        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;

        if (start === end) {
            // No selection
            const placeholder = '**Teks Tebal**';
            textarea.value = text.substring(0, start) + placeholder + text.substring(end);
            textarea.setSelectionRange(start + 2, start + placeholder.length - 2);
        } else {
            const selected = text.substring(start, end);
            textarea.value = text.substring(0, start) + `**${selected}**` + text.substring(end);
            textarea.setSelectionRange(start + 2, end + 2);
        }

        textarea.dispatchEvent(new Event('input', { bubbles: true }));
        textarea.focus();
    },

    clearFormatting() {
        const textarea = this.$refs.editorTextarea;
        if (!textarea) return;

        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;

        const lineStart = text.lastIndexOf('\n', start - 1) + 1;
        let lineEnd = text.indexOf('\n', end);
        if (lineEnd === -1) lineEnd = text.length;

        const selectedLines = text.substring(lineStart, lineEnd).split('\n');
        const cleanedLines = selectedLines.map(l => {
            return l.replace(/^(\s*)(•\s?|\d+\.\s?|-\s?|\*\s?)/, '$1').replace(/\*\*(.*?)\*\*/g, '$1');
        });

        textarea.value = text.substring(0, lineStart) + cleanedLines.join('\n') + text.substring(lineEnd);
        textarea.dispatchEvent(new Event('input', { bubbles: true }));
        textarea.focus();
    },

    handleEnter(event) {
        const textarea = this.$refs.editorTextarea;
        if (!textarea) return;

        const cursor = textarea.selectionStart;
        const text = textarea.value;
        const lineStart = text.lastIndexOf('\n', cursor - 1) + 1;
        const currentLine = text.substring(lineStart, cursor);

        // Check if current line is a bullet
        const bulletMatch = currentLine.match(/^(\s*)•\s*(.*)$/);
        if (bulletMatch) {
            event.preventDefault();
            const indent = bulletMatch[1];
            const content = bulletMatch[2];

            if (content.trim() === '') {
                // User pressed enter on an empty bullet line -> exit list
                const newText = text.substring(0, lineStart) + text.substring(cursor);
                textarea.value = newText;
                textarea.setSelectionRange(lineStart, lineStart);
            } else {
                // Continue bullet on next line
                const insertion = `\n${indent}• `;
                textarea.value = text.substring(0, cursor) + insertion + text.substring(cursor);
                textarea.setSelectionRange(cursor + insertion.length, cursor + insertion.length);
            }
            textarea.dispatchEvent(new Event('input', { bubbles: true }));
            return;
        }

        // Check if current line is a numbered list
        const numberMatch = currentLine.match(/^(\s*)(\d+)\.\s*(.*)$/);
        if (numberMatch) {
            event.preventDefault();
            const indent = numberMatch[1];
            const currentNum = parseInt(numberMatch[2], 10);
            const content = numberMatch[3];

            if (content.trim() === '') {
                // User pressed enter on an empty numbered line -> exit list
                const newText = text.substring(0, lineStart) + text.substring(cursor);
                textarea.value = newText;
                textarea.setSelectionRange(lineStart, lineStart);
            } else {
                // Continue with next number
                const insertion = `\n${indent}${currentNum + 1}. `;
                textarea.value = text.substring(0, cursor) + insertion + text.substring(cursor);
                textarea.setSelectionRange(cursor + insertion.length, cursor + insertion.length);
            }
            textarea.dispatchEvent(new Event('input', { bubbles: true }));
            return;
        }
    }
}">
    <!-- Smart Micro-Toolbar -->
    <div class="flex items-center justify-between px-3 py-1.5 bg-slate-100/90 rounded-t-xl border border-b-0 border-slate-200 text-xs">
        <div class="flex items-center gap-1">
            <!-- Bullet List Button -->
            <button
                type="button"
                @click="insertPrefix('bullet')"
                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-white hover:bg-red-50 text-slate-700 hover:text-[#A6192E] border border-slate-200/80 hover:border-red-200 font-semibold shadow-2xs transition cursor-pointer"
                title="Daftar Poin (Bullet List)"
            >
                <span class="text-sm font-bold leading-none">•</span>
                <span class="text-[11px]">Poin (Bullet)</span>
            </button>

            <!-- Numbered List Button -->
            <button
                type="button"
                @click="insertPrefix('number')"
                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-white hover:bg-red-50 text-slate-700 hover:text-[#A6192E] border border-slate-200/80 hover:border-red-200 font-semibold shadow-2xs transition cursor-pointer"
                title="Daftar Nomor (Numbered List)"
            >
                <span class="text-[11px] font-bold leading-none">1.</span>
                <span class="text-[11px]">Nomor</span>
            </button>

            <!-- Bold Button -->
            <button
                type="button"
                @click="insertBold()"
                class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-white hover:bg-red-50 text-slate-700 hover:text-[#A6192E] border border-slate-200/80 hover:border-red-200 font-bold shadow-2xs transition cursor-pointer"
                title="Tebalkan Teks"
            >
                <span class="text-xs font-black">B</span>
            </button>

            <!-- Clear Formatting Button -->
            <button
                type="button"
                @click="clearFormatting()"
                class="inline-flex items-center px-2 py-1 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-200/70 transition cursor-pointer text-[11px]"
                title="Hapus format list baris ini"
            >
                <span class="material-symbols-outlined text-[15px]">format_clear</span>
            </button>
        </div>

        <span class="text-[10px] text-slate-400 hidden sm:inline">
            Tips: Tekan <kbd class="px-1 py-0.5 rounded bg-white border border-slate-200 text-[10px] font-mono">Enter</kbd> untuk melanjutkan poin
        </span>
    </div>

    <!-- Native Textarea with Keyboard Handler -->
    <textarea
        x-ref="editorTextarea"
        name="{{ $name }}"
        id="{{ $inputId }}"
        rows="{{ $rows }}"
        @keydown.enter="handleEnter($event)"
        class="w-full px-4 py-2.5 text-xs rounded-b-xl rounded-t-none border {{ $hasError ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition leading-relaxed resize-y font-sans"
        placeholder="{{ $placeholder }}"
        @if ($required) required @endif
    >{{ $value }}</textarea>
</div>

