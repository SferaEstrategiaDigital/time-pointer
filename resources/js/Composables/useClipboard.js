import { ref } from "vue";

export default function useClipboard() {
    const copied = ref(false);

    const copyToClipboard = (text) => {
        navigator.clipboard
            .writeText(text)
            .then(() => {
                copied.value = true;
            })
            .catch((error) => {
                console.error(
                    "Erro ao copiar para a área de transferência:",
                    error
                );
            });
    };

    const readFromClipboard = () => {
        return navigator.clipboard.readText();
    };

    return {
        copied,
        copyToClipboard,
        readFromClipboard,
    };
}
